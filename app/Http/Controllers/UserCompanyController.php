<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\FavoriteCompany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;


class UserCompanyController extends Controller
{
    //
    public function getCompany(Request $request, $query)
    {
        $companies = $this->findCompany($query);
        return response()->json($companies);
    }

    public function findCompany($query)
    {
        return Company::Where('company_name', 'ilike', '%' . $query . '%')->take(10)->get();
    }

    public function addMyCompany(Request $request)
    {
        $userid = $request->user()->id;
        $companyid = $request->input("id");
        $validator = $this->validator($request);
        if ($validator !== true) {
            throw new AuthenticationException(
                $validator->errors()
            );
        }
        $this->addUserCompany($userid, $companyid);
        return response()->json("OK");
    }

    protected function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }


    public function addUserCompany($userid, $companyid)
    {
        $fv = new FavoriteCompany;
        $fv->user_id = $userid;
        $fv->company_id = $companyid;
        $fv->save();
        return true;
    }

    public function getMyCompany(Request $request)
    {
        $userid = $request->user()->id;
        return response()->json($this->getCompanyByUserID($userid));
    }

    public function getCompanyByUserID($userid)
    {
        return Company::join('favorite_companies', 'companies.id', '=', 'favorite_companies.company_id')
            ->select('companies.*', 'favorite_companies.user_id')->where('favorite_companies.user_id', '=', $userid)
            ->get();
    }

    public function deleteCompany(Request $request)
    {
        $companyid = $request->input("company_id");
        $count = FavoriteCompany::where('company_id', $companyid)->count();
        if ($count > 0) {
            $company = FavoriteCompany::where('company_id', $companyid)->get();
            if ($company->user_id !== $request->user()->id) {
                throw new AuthenticationException(
                    'Unauthenticated'
                );
            } else {
                $this->deleteCompanyByCompanyID($companyid);
                return response()->json("OK");
            }
        } else {
            throw new AuthenticationException(
                'Company ID not fnound'
            );
        }
    }

    public function deleteCompanyByCompanyID($companyid)
    {
        return FavoriteCompany::where('company_id', '=', $companyid)->delete();
    }
}
