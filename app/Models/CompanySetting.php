<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    const KEY_BILLING_ALERT = 'billing_alert';

    const KEY_IPS_WHITELISTING = 'ips_whitelisting';

    const KEY_IPS_BLACKLISTING = 'ips_blacklisting';

    const KEYS = [
        self::KEY_BILLING_ALERT => '0',
        self::KEY_IPS_WHITELISTING => '',
        self::KEY_IPS_BLACKLISTING => '',
    ];

    protected $fillable = [
        'company_id',
        'key',
        'value',
    ];

    protected $hidden = [
        'company',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
