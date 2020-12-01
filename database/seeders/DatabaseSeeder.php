<?php

namespace Database\Seeders;
use App\Acl;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$roles = [];

		foreach (Acl::roles() as $role)
		{
			$roles[strtolower($role)] = Role::findOrCreate($role, 'api');
		}
		foreach (Acl::permissions() as $permission)
		{
			Permission::findOrCreate(strtolower($permission), 'api');
		}
		$roles[strtolower(Acl::ROLE_ADMIN)]->givePermissionTo([ACL::PERMISSION_USER_MANAGE]);
		$roles[strtolower(Acl::ROLE_USER)]->givePermissionTo([ACL::PERMISSION_NSE_VIEW]);

		$validatedData = ([
			'name' => 'rajneesh',
			'email' => 'rajneeshojha123@gmail.com',
			'password' => 'o5m4e3g2a1',
		]);
		$validatedData['password'] = bcrypt($validatedData['password']);
		$user = User::whereEmail('rajneeshojha123@gmail.com')->first();
		if (!$user)
		{
			$user = User::create($validatedData);
		}
		$user->assignRole(Acl::ROLE_ADMIN);
	}
}
