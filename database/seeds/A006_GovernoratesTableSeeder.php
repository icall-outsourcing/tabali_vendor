<?php

use Illuminate\Database\Seeder;

class A006_GovernoratesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('governorates')->insert([
            ['id' => '1','name' => 'القاهره'],
        ]);
    }
}