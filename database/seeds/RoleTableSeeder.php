<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $create_users = Permission::where('slug','create-users')->first();
        $edit_users = Permission::where('slug','edit-users')->first();
        

        $create_roles = Permission::where('slug','create-roles')->first();
        $edit_roles = Permission::where('slug','edit-roles')->first();

        $create_permissions = Permission::where('slug','create-permissions')->first();
        $edit_permissions = Permission::where('slug','edit-permissions')->first();
       


		$dev_role = new Role();
		$dev_role->slug = 'super';
		$dev_role->name = 'Super Admin';
		$dev_role->save();
		
		$dev_role = new Role();
		$dev_role->slug = 'admin';
		$dev_role->name = 'Admin';
		$dev_role->save();
		$dev_role->permissions()->attach($create_users);
		$dev_role->permissions()->attach($edit_users);
		$dev_role->permissions()->attach($create_roles);
		$dev_role->permissions()->attach($edit_roles);
		$dev_role->permissions()->attach($create_permissions);
		$dev_role->permissions()->attach($edit_permissions);

    }
}
 