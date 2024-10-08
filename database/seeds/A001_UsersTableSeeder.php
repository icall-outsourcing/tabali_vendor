<?php

use Illuminate\Database\Seeder;

class A001_UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['id' => '1' ,'name' => 'Admin'              ,'email' => 'karim.mokhtar@icall.com.eg'           ,'password' => bcrypt('welcome')],
            ['id' => '2' ,'name' => 'Team Leader'        ,'email' => 'teamleader@icall.com.eg'              ,'password' => bcrypt('welcome')],
            ['id' => '3' ,'name' => 'Agent'              ,'email' => 'agent@icall.com.eg'                   ,'password' => bcrypt('welcome')],
            ['id' => '4' ,'name' => 'Mohamed Abuali'     ,'email' => 'mohamed.abuali@othaimmarkets.com.eg'  ,'password' => bcrypt('welcome')],
            ['id' => '5' ,'name' => 'Abd elfatah Ramadan','email' => 'a.ramadan@othaimmarkets.com.eg'       ,'password' => bcrypt('welcome')],
            ['id' => '6' ,'name' => 'Alaa Elhalawany'    ,'email' => 'a.elhalawany@othaimmarkets.com.eg'    ,'password' => bcrypt('welcome')],
            ['id' => '7' ,'name' => 'Ahmed fahmy'        ,'email' => 'a.fahmy@othaimmarkets.com.eg'         ,'password' => bcrypt('welcome')],
            ['id' => '8' ,'name' => 'Adel Hashem'        ,'email' => 'a.hashem@othaimmarkets.com.eg'        ,'password' => bcrypt('welcome')],
            ['id' => '9' ,'name' => 'Ahmed Raafat'       ,'email' => 'a.raafat@othaimmarkets.com.eg'        ,'password' => bcrypt('welcome')],
            ['id' => '10','name' => 'Mamoud abd elhameid','email' => 'm.abdelhameid@othaimmarkets.com.eg'   ,'password' => bcrypt('welcome')],
            ['id' => '11','name' => 'Ahmed el shahat'    ,'email' => 'y.fathy@othaimmarkets.com.eg'         ,'password' => bcrypt('welcome')],
            ['id' => '12','name' => 'Yasser fathy'       ,'email' => 'a.elshahat@othaimmarkets.com.eg'      ,'password' => bcrypt('welcome')]
        ]);
    }
}