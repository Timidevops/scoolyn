<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;
    use UsesTenantConnection;
}
