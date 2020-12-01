<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
	use UsesUuid;

}
