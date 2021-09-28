<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;

class Navigation extends Model
{
    use HasFactory;

    public function scopeHeader(Builder $query): Builder
    {
        return $query->where('position', '=', 'header');
    }

    public function scopeSidebar(Builder $query): Builder
    {
        return $query->where('position', '=', 'sidebar');
    }

    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('site', '=', 'admin');
    }

    public function scopeFrontend(Builder $query): Builder
    {
        return $query->where('site', '=', 'frontend');
    }

    public function scopeParent(Builder $query): Builder
    {
        return $query->whereNull('parent');
    }

    public function subs()
    {
        return $this->hasMany(Navigation::class, 'parent', 'name');
    }
}
