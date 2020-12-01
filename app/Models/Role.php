<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
	use UsesUuid;
}
