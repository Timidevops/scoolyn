<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;
    use UsesTenantConnection;
}
