<?php

namespace App\Traits;

trait ScopeEnabled
{
    /**
     * Scope a query to only include enabled items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }
}
