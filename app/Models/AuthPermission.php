<?php

namespace App\Models;

use App\Traits\ScopeEnabled;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthPermission extends Model
{
    use HasFactory;
    use ScopeEnabled;

    protected $hidden = ['pivot'];

    public function roles()
    {
        return $this->morphedByMany(AuthRole::class, 'assignable');
    }
}
