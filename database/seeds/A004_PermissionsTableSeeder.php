<?php

use Illuminate\Database\Seeder;

class A004_PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['id' => '1' ,'name' => 'Nozha','slug' => 'Nozha','description' => 'Nozha'],
            ['id' => '2' ,'name' => 'Dokki','slug' => 'Dokki','description' => 'Dokki']
        ]);
    }
}
