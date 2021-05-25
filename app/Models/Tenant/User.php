<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Permission\Traits\HasRoles;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;
    use ReceivesWelcomeNotification;

    const SUPER_ADMIN_USER ='super_admin';
    const ADMIN_USER = 'admin';
    const TEACHER_USER = 'teacher';
    const STUDENT_USER = 'student';
    const PARENT_USER = 'parent';

    protected $guarded = [];

    public function teacher(): HasMany
    {
        return $this->hasMany(Teacher::class, 'user_id', 'uuid');
    }

    public function parent(): HasMany
    {
        return $this->hasMany(Parents::class, 'user_id', 'uuid');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
