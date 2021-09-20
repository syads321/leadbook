<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\FavoriteCompany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;

class UserCompanyController extends Controller
{
    /**
     * Query company based on keyword.
     * Route : api/companies/{query} (GET)
     * @return Illuminate\Contracts\Routing\ResponseFactory::json
     */
    public function getCompany(Request $request, $query)
    {
        $companies = $this->findCompany($query);
        if (count($companies) === 0) {
            throw new AuthenticationException(
                "Company not found"
            );
        }
        return response()->json($companies);
    }

    /**
     * Query company from database.
     * @return Array
     */
    public function findCompany($query)
    {
        return Company::Where('company_name', 'ilike', '%' . $query . '%')->take(10)->get();
    }

    /**
     * Add company to company list.
     * Route : /addmycompany (POST)
     * { id : {companyid}}
     * @return Illuminate\Contracts\Routing\ResponseFactory::json
     */
    public function addMyCompany(Request $request)
    {
        $userid = $request->user()->id;
        $companyid = $request->input("id");
        $validator = $this->addCompanyValidator($request);
        if ($validator !== true) {
            throw new AuthenticationException(
                $validator->errors()
            );
        }
        $this->addUserCompany($userid, $companyid);
        return response()->json("OK");
    }

    /**
     * Add user company request validator.
     * @return Bool
     */
    protected function addCompanyValidator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    
    /**
     * Add row mapping of user and company.
     * @return Bool
     */
    public function addUserCompany($userid, $companyid)
    {
        $fv = new FavoriteCompany;
        $fv->user_id = $userid;
        $fv->company_id = $companyid;
        $fv->save();
        return true;
    }

    /**
     * Response request of user's company list.
     * @return Illuminate\Contracts\Routing\ResponseFactory::json
     */
    public function getMyCompany(Request $request)
    {
        $userid = $request->user()->id;
        return response()->json($this->getCompanyByUserID($userid));
    }

     /**
     * Get company list based on user id from database.
     * @return Array
     */
    public function getCompanyByUserID($userid)
    {
        return Company::join('favorite_companies', 'companies.id', '=', 'favorite_companies.company_id')
            ->select('companies.*', 'favorite_companies.user_id')->where('favorite_companies.user_id', '=', $userid)
            ->get();
    }

    /**
     * Delete company from users company list.
     * @return Illuminate\Contracts\Routing\ResponseFactory::json
     */
    public function deleteMyCompany(Request $request)
    {
        $companyid = $request->input("company_id");
        $count = FavoriteCompany::where('company_id', $companyid)->count();
        // Make sure the selected company is exist
        if ($count > 0) {
            $company = FavoriteCompany::where('company_id', $companyid)->get();
            // Check rows ownersip of the company to user mapping
            if ($company[0]->user_id !== $request->user()->id) {
                throw new AuthenticationException(
                    'Unauthenticated'
                );
            } else {
                $this->deleteCompanyByCompanyID($companyid, $request->user()->id);
                return response()->json("OK");
            }
        } else {
            throw new AuthenticationException(
                'Company ID not fnound'
            );
        }
    }

    /**
     * Delete company from users company list in database.
     * @return Array
     */
    public function deleteCompanyByCompanyID($companyid, $userid)
    {
        return FavoriteCompany::where([
            ['company_id', '=', $companyid],
            ['user_id', '=', $userid]
        ])->delete();
    }
}
