<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class CompanyInfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_company_information')->insert([
            'company_name' => 'Far-East IT Solutions Limited',
            'company_phone' => '01852665521',
            'company_email' => 'info@feits.co',
            'company_address' => 'House #51, Road #18, Sector #11',
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }
}
