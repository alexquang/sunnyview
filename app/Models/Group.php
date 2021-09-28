<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'description'
    ];

    protected $casts = [
        'updated_at' => 'datetime:Y-m-d h:m:s',
    ];

    public function users()
    {
        return $this->hasMany(AuthUser::class, 'company_id', 'company_id');
    }
}
