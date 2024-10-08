<?php

use Illuminate\Database\Seeder;

class A005_PermissionUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_user')->insert([
        	['permission_id' => '1','user_id' => '1'],
        	['permission_id' => '2','user_id' => '1'],
        	['permission_id' => '1','user_id' => '4'],
            ['permission_id' => '2','user_id' => '4'],
            ['permission_id' => '2','user_id' => '5'],
            ['permission_id' => '1','user_id' => '6'],
            ['permission_id' => '1','user_id' => '7'],
            ['permission_id' => '2','user_id' => '8'],
            ['permission_id' => '2','user_id' => '9'],
            ['permission_id' => '1','user_id' => '10'],
            ['permission_id' => '1','user_id' => '11'],
        	['permission_id' => '2','user_id' => '12']
        ]);
    }
}
