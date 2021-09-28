<?php

namespace App\Models;

use App\Traits\ScopeEnabled;
use App\Traits\AuthPermissionAssignable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthRole extends Model
{
    use HasFactory, SoftDeletes, ScopeEnabled;
    use AuthPermissionAssignable;

    protected $fillable = [
        'name',
        'description',
        'is_enabled',
        'is_published',
    ];

    protected $hidden = ['users'];

    public function scopePublished($query)
    {
        return $query->where('is_published', '=', true);
    }

    public function users()
    {
        return $this->morphedByMany(AuthUser::class, 'assignable', 'auth_assigned_roles');
    }
}
