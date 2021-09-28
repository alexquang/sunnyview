<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDownloadHistory extends Model
{
    use HasFactory;

    const CREATED_AT = null;

    const UPDATED_AT = null;

    protected $hidden = [
        'user',
        'invoice',
    ];

    public function user()
    {
        return $this->belongsTo(AuthUser::class, 'downloaded_by');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
