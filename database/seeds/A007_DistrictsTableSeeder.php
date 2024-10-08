<?php

use Illuminate\Database\Seeder;

class A007_DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([
        	['id' => '1','governorate_id' => '1','name' => 'النزهة'],
        	['id' => '2','governorate_id' => '1','name' => 'الدقى']
        ]);
    }
}
