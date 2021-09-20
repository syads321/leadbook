<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Company;
use App\Http\Controllers\UserCompanyController;

class CompanyTest extends TestCase
{
    /**
     * Testing feature for Company model related databases.
     *
     * @return void
     */
    protected $userid = 1;
    protected $companyid = 1;
    
    public function testCreateCompany()
    {
        $data = array(
            (object) [
                "company_name" => "Microsoft",
                "address" => "Palo Alto CA",
                "phonenumber" => "+1 6478383930"
            ],
        );

        foreach($data as $company) {
            $cmp = new Company();
            $cmp->company_name = $company->company_name;
            $cmp->address = $company->address;
            $cmp->phonenumber = $company->phonenumber;
            $cmp->save();
        }

        $this->assertDatabaseHas('companies', [
            'company_name' => $data[0]->company_name,
        ]);
    }

    public function testUserSelectCompany() {
        $controller = new UserCompanyController;
        $controller->addUserCompany($this->userid, $this->companyid);
        $this->assertDatabaseHas('favorite_companies', [
            'user_id' => $this->userid,
        ]);
    }

    public function testUserUnselectCompany() {
        $controller = new UserCompanyController;
        $controller->deleteCompanyByCompanyID($this->userid, $this->companyid);
        $this->assertDatabaseMissing('favorite_companies', [
            'user_id' => $this->userid,
        ]);
    }
}
