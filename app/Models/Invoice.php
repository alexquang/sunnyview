<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $hidden = [
        'awsAccount',
        'downloadSetting',
        'downloadHistories',
    ];

    public function awsAccount()
    {
        return $this->belongsTo(AwsAccount::class, 'aws_usage_account_id', 'account_id');
    }

    public function downloadSetting()
    {
        return $this->hasOne(InvoiceDownloadSetting::class);
    }

    public function downloadHistories()
    {
        return $this->hasMany(InvoiceDownloadHistory::class);
    }
}
