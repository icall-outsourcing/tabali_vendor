<?php

use Illuminate\Database\Seeder;

class A008_AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            ['id' => '1','district_id' => '1','name' => 'النزهة'],
        	['id' => '2','district_id' => '2','name' => 'الدقى']
        ]);
    }
}
