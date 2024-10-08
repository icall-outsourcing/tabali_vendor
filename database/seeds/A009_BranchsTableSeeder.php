<?php

use Illuminate\Database\Seeder;

class A009_BranchsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branchs')->insert([
            ['id' => '1','name' => 'النزهة'],
            ['id' => '2','name' => 'الدقى']
        ]);
    }
}
