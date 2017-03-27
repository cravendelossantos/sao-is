<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
		$role_admin->name = 'Admin';
		$role_admin->description = 'SAO Administrator';
		$role_admin->save();
		
		$role_secretary = new Role();
		$role_secretary->name = 'Secretary';
		$role_secretary->description = 'SAO Secretary';
		$role_secretary->save();

    }
}
