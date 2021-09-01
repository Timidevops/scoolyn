<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Permission\Traits\HasRoles;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;
    use ReceivesWelcomeNotification;
    use SoftDeletes;
    use UsesTenantConnection;

    const SUPER_ADMIN_USER ='super_admin';
    const ADMIN_USER = 'admin';
    const CLASS_TEACHER_USER = 'class_teacher';
    const SUBJECT_TEACHER_USER = 'subject_teacher';
    const PARENT_USER = 'parent';

    protected $guarded = [];

    public function teacher(): HasMany
    {
        return $this->hasMany(Teacher::class, 'user_id', 'uuid');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(Parents::class, 'user_id', 'uuid');
    }

    public function getUserFullName()
    {
        return $this->name;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
