<?php

use Illuminate\Database\Seeder;
Use App\Role;
use App\Permission;
use App\User;

class UserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //UserTableSeeder.php
	$admin_role = Role::where('slug','admin')->first();
	$super_role = Role::where('slug', 'super')->first();
	// $dev_perm = Permission::where('slug','create-tasks')->first();
	// $manager_perm = Permission::where('slug','edit-users')->first();

	$developer = new User();
	$developer->name = 'Super Admin';
	$developer->email = 'usama@thewebtier.com';
	$developer->password = bcrypt('secret');
	$developer->save();
	$developer->roles()->attach($admin_role);
	// $developer->permissions()->attach($dev_perm);


	$manager = new User();
	$manager->name = 'Asad Butt';
	$manager->email = 'asad@thewebtier.com';
	$manager->password = bcrypt('secret');
	$manager->save();
	$manager->roles()->attach($super_role); 
	// $manager->permissions()->attach($manager_perm);
    }
}
