<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(A001_UsersTableSeeder::class);
        $this->call(A002_RolesTableSeeder::class);
        $this->call(A003_RoleUserTableSeeder::class);
        $this->call(A004_PermissionsTableSeeder::class);
        $this->call(A005_PermissionUserTableSeeder::class);
        $this->call(A006_GovernoratesTableSeeder::class);
        $this->call(A007_DistrictsTableSeeder::class);
        $this->call(A008_AreasTableSeeder::class);
        $this->call(A009_BranchsTableSeeder::class);
        
    }
}
