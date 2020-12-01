<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 */
final class Acl
{
	const ROLE_ADMIN = 'Administrator';
	const ROLE_USER = 'User';

	const ADMIN_ROLES = [self::ROLE_ADMIN];

	const PERMISSION_USER_CREATE = 'user.create';
	const PERMISSION_USER_EDIT = 'user.modify';
	const PERMISSION_USER_DELETE = 'user.delete';
	const PERMISSION_USER_VIEW = 'user.view';
	const PERMISSION_USER_VIEW_ALL = 'user.view_all';
	const PERMISSION_USER_MANAGE = 'user.manage';


	const PERMISSION_NSE_VIEW = 'nse.view';
	 

	/**
	 * @param array $exclusives Exclude some permissions from the list
	 * @return array
	 */
	private $consts = [];

	private static function getConstants()
	{
		static $constants;
		if (!$constants)
		{
			$class = new \ReflectionClass(__CLASS__);
			$constants = $class->getConstants();
		}

		return $constants;
	}
	public static function permissions(array $exclusives = []): array
	{
		try {
			$constants = self::getConstants();
			$permissions = Arr::where($constants, function ($value, $key) use ($exclusives)
			{
				return !in_array($value, $exclusives) && Str::startsWith($key, 'PERMISSION_');
			});

			return array_values($permissions);
		}
		catch (\ReflectionException $exception)
		{
			return [];
		}
	}
	public static function plan_permissions(array $exclusives = []): array
	{
		try {
			$constants = self::getConstants();
			$permissions = Arr::where($constants, function ($value, $key) use ($exclusives)
			{
				return !in_array($value, $exclusives) && Str::startsWith($key, 'PERMISSION_ABILITY');
			});

			return array_values($permissions);
		}
		catch (\ReflectionException $exception)
		{
			return [];
		}
	}

	public static function menuPermissions(): array
	{
		try {
			$class = new \ReflectionClass(__CLASS__);
			$constants = $class->getConstants();
			$permissions = Arr::where($constants, function ($value, $key)
			{
				return Str::startsWith($key, 'PERMISSION_VIEW_MENU_');
			});

			return array_values($permissions);
		}
		catch (\ReflectionException $exception)
		{
			return [];
		}
	}

	/**
	 * @return array
	 */
	public static function roles(): array
	{
		return array_values(self::roles_assoc());
	}
	public static function roles_assoc(): array
	{
		try {
			$class = new \ReflectionClass(__CLASS__);
			$constants = $class->getConstants();
			$roles = Arr::where($constants, function ($value, $key)
			{
				return Str::startsWith($key, 'ROLE_');
			});

			return ($roles);
		}
		catch (\ReflectionException $exception)
		{
			return [];
		}
	}
	public static function join()
	{
		$args = get_func_args();
		$constants = self::getConstants();
		$permissions = Arr::where($constants, function ($value, $key) use ($args)
		{
			return in_array($args, $key);
		});

		return implode("|", $permissions);
	}

	public static function forModule($module, $perms, $exclude = [], $join = true)
	{
		$constants = self::getConstants();
		$perms = is_array($perms) ? $perms : [$perms];
		$perm_arr = [];
		$permissions = Arr::where($constants, function ($value, $key) use ($perms, $module, $exclude)
		{
			if (Str::startsWith($key, 'PERMISSION_'.strtoupper($module)."_"))
			{
				if (count($perms) == 1 && $perms[0] == '*')
				{
					return true;
				}
				else
				{
					foreach ($perms as $perm)
					{
						$name = 'PERMISSION_'.strtoupper($module)."_".strtoupper($perm);
						if (!in_array($name, $exclude) && Str::startsWith($key, $name))
						{
							return true;
						}
					}

					return false;
				}
			}
		});

		return $join ? implode("|", $permissions) : $permissions;
	}
}
