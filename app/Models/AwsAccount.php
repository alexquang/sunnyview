<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwsAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'account_id',
        'account_name',
        'iam_role_name',
        's3_bucket_dbr',
        's3_bucket_cur',
        'external_id',
        'is_reseller',
    ];

    public function scopeReseller(Builder $query): Builder
    {
        return $query->where('is_reseller', true)
            ->whereNotNull('s3_bucket_dbr')
            ->whereNotNull('s3_bucket_cur');
    }

    public function scopeUnLinked(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->whereNull('iam_role_name')
                ->orWhereNull('external_id');
        });
    }

    public function generateRoleArn()
    {
        return "arn:aws:iam::{$this->account_id}:role/{$this->iam_role_name}";
    }
}
