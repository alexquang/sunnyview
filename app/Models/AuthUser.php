<?php

namespace App\Models;

use App\Traits\AuthPermissionAssignable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as EloquentUser;
use Illuminate\Notifications\Notifiable;

class AuthUser extends EloquentUser
{
    use HasFactory, Notifiable, SoftDeletes;
    use AuthPermissionAssignable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_enabled',
        'group_id',
        'company_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'company',
        'group',
        'roles',
        'projects',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeInternal($query)
    {
        return $query->whereNull('company_id');
    }

    public function roles()
    {
        return $this->morphToMany(AuthRole::class, 'assignable', 'auth_assigned_roles');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'assigned_projects');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function listAssignedPermissions($forceReload = false)
    {
        return \Cache::get("sv_assigned_permissions_{$this->id}", function () {
            \Log::info("User [id={$this->id}] has requested their assigned permissions.");

            // retrive inline-permissions
            $permissions = $this->permissions;

            // retrive all assigned permissions via roles
            $this->roles->each(function ($role) use (&$permissions) {
                $permissions = $permissions->merge($role->permissions);
            });

            $permissions = $permissions->groupBy('name')->map(function ($assignedPermissions) {
                return $assignedPermissions->first();
            })->toArray();
            \Cache::put("sv_assigned_permissions_{$this->id}", $permissions);

            return $permissions;
        });
    }
}
