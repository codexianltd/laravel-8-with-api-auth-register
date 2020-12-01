<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
	public function toArray($request)
	{
		$roles = [];

		$permissions = [
			'roles' => [],
			'direct' => [],
		];
		foreach ($this->getPermissionsViaRoles() as $item)
		{
			$permissions['roles'][strtolower($item->name)] = $item;
		}
		if (empty($permissions['roles']))
		{
			$permissions['roles'] = new \StdClass();
		}
		foreach ($this->permissions as $item)
		{
			$permissions['direct'][strtolower($item->name)] = $item;
		}
		if (empty($permissions['direct']))
		{
			$permissions['direct'] = new \StdClass();
		}
		foreach ($this->roles as $item)
		{
			$roles[strtolower($item->name)] = ($item);
		}
		if (empty($roles))
		{
			$roles = new \StdClass();
		}

		$data = [
			'id' => $this->uuid ? $this->uuid : $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'roles' => $roles,
			'permissions' => $permissions,

		];

		return $data;
	}
}
