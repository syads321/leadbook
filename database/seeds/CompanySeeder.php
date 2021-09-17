<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            (object) [
                "company_name" => "Microsoft",
                "address" => "Palo Alto CA",
                "phonenumber" => "+1 6478383930"
            ],
            (object) [
                "company_name" => "Yahoo",
                "address" => "Quahog RI",
                "phonenumber" => "+1 64d383930"
            ],
            (object) [
                "company_name" => "Google",
                "address" => "Michigan CA",
                "phonenumber" => "+1 6478344930"
            ],
            (object) [
                "company_name" => "Nokia",
                "address" => "Avenue NY",
                "phonenumber" => "+1 64558383930"
            ],
            (object) [
                "company_name" => "Amazon",
                "address" => "Arizona CA",
                "phonenumber" => "+1 6668383930"
            ]
        );

        foreach($data as $company) {
            $cmp = new Company();
            $cmp->company_name = $company->company_name;
            $cmp->address = $company->address;
            $cmp->phonenumber = $company->phonenumber;
            $cmp->save();
        }
    }
}
