<?php

use Illuminate\Database\Seeder;

class A002_RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => '1' ,'name' => 'Admin'      ,'slug' => 'admin'		,'description' => 'description'],
            ['id' => '2' ,'name' => 'Team Leader','slug' => 'teamleader','description' => 'description'],
            ['id' => '3' ,'name' => 'Agent'      ,'slug' => 'agent'   	,'description' => 'description'],
            ['id' => '4' ,'name' => 'branch'     ,'slug' => 'branch'    ,'description' => 'description']
        ]);
    }
}
