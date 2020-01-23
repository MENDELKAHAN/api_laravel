<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_role = Role::where('slug','super')->first();
		$admin_role = Role::where('slug', 'admin')->first();

		$create_users = new Permission();
		$create_users->slug = 'create-users';
		$create_users->name = 'Create Users';
		$create_users->save();
		$create_users->roles()->attach($admin_role);

		$edit_users = new Permission();
		$edit_users->slug = 'edit-user';
		$edit_users->name = 'Edit User';
		$edit_users->save();
		$edit_users->roles()->attach($admin_role);

		$create_roles = new Permission();
		$create_roles->slug = 'create-roles';
		$create_roles->name = 'Create Roles';
		$create_roles->save();
		$create_roles->roles()->attach($admin_role);

		$edit_roles = new Permission();
		$edit_roles->slug = 'edit-roles';
		$edit_roles->name = 'Edit Roles';
		$edit_roles->save();
		$edit_roles->roles()->attach($admin_role);

		$create_permissions = new Permission();
		$create_permissions->slug = 'create-permissions';
		$create_permissions->name = 'Create Permissions';
		$create_permissions->save();
		$create_permissions->roles()->attach($admin_role);

		$edit_permissions = new Permission();
		$edit_permissions->slug = 'edit-permissions';
		$edit_permissions->name = 'Edit Permissions';
		$edit_permissions->save();
		$edit_permissions->roles()->attach($admin_role);

		

    }
}
 
