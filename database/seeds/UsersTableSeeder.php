<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	
    	$role_admin = Role::where('name', 'Admin')->first();	
    	$role_secretary = Role::where('name', 'Secretary')->first();			
		
    	$admin = new User();
		$admin->first_name = 'SAO';
		$admin->last_name = 'LPU CAVITE';
		$admin->email = 'saolpucvt@gmail.com';
    	$admin->password = bcrypt('saoadmin');
    	$admin->contact_no = '+639123456789';
    	$admin->address = 'Generial Trias, Cavite';
    	$admin->birthdate = '1996-11-17';
		$admin->save();
		$admin->roles()->attach($role_admin);


	 	$admin1 = new User();
		$admin1->first_name = 'Craven';
		$admin1->last_name = 'Delos Santos';
		$admin1->email = 'delossantoscraven@gmail.com';
    	$admin1->password = bcrypt('craven');
    	$admin1->contact_no = '+639367936905';
    	$admin1->address = '388 3rd St., Salinas, Bacoor, Cavite';
    	$admin1->birthdate = '1996-11-17';
		$admin1->save();
		$admin1->roles()->attach($role_admin);
		

	 	/*$admin2 = new User();
		$admin2->first_name = 'Elmar';
		$admin2->last_name = 'Anchuelo';
		$admin2->email = 'ejanchuelo@gmail.com';
    	$admin2->password = bcrypt('elmar');
    	$admin2->contact_no = '+63921345678';
    	$admin2->address = 'Tierra Nevada, General Trias, Cavite';
    	$admin2->birthdate = '1990-11-01';
		$admin2->save();
		$admin2->roles()->attach($role_admin);

		$secretary = new User();
		$secretary->first_name = 'Kim';
		$secretary->last_name = 'Comission';
		$secretary->email = 'kim@gmail.com';
		$secretary->password = bcrypt('kimguian');
		$secretary->contact_no = '+639873627444';
		$secretary->address = 'Manggahan, General Trias, Cavite';
		$secretary->birthdate = '1994-01-01';
		$secretary->save();
		$secretary->roles()->attach($role_secretary);
*/
		
	}
}
