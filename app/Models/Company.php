<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;

class Company extends Model
{
    const PAY_DAY_OPTIONS = [
        ['key' => 30, 'name' => '翌月末'],
        ['key' => 35, 'name' => '翌々月5日'],
        ['key' => 40, 'name' => '翌々月10日'],
        ['key' => 45, 'name' => '翌々月15日'],
        ['key' => 50, 'name' => '翌々月20日'],
        ['key' => 55, 'name' => '翌々月25日'],
        ['key' => 60, 'name' => '翌々月末'],
        ['key' => 65, 'name' => '翌翌々月5日'],
        ['key' => 90, 'name' => '翌翌々月末'],
        ['key' => -1, 'name' => '請求しない(社内・運用契約)'],
    ];

    const DELIVERY_OPTIONS = [
        ['key' => -1, 'name' => '未設定'],
        ['key' => 1, 'name' => '郵送'],
        ['key' => 2, 'name' => 'eメール送信'],
    ];

    const INVOICE_TYPE_OPTIONS = [
        ['key' => -1, 'name' => '明細なし'],
        ['key' => 1, 'name' => 'AWSアカウントIDのみ表示'],
        ['key' => 2, 'name' => 'アカウント名称のみ表示'],
        ['key' => 3, 'name' => 'AWSアカウントID、アカウント名称を表示'],
        ['key' => 4, 'name' => 'アカウント名称に自由記入して表示'],
    ];

    const INVOICE_DATE_OPTIONS = [
        ['key' => -1, 'name' => '未設定'],
        ['key' => 0, 'name' => '当月末日'],
        ['key' => 1, 'name' => '翌月1日'],
    ];

    const CREDIT_CARD_ISSUER = [
        ['key' => -1, 'name' => '未設定'],
        ['key' => 1, 'name' => 'AMEX'],
        ['key' => 2, 'name' => '三井住友VISA'],
        ['key' => 3, 'name' => 'りそな'],
    ];

    const BANK_ACCOUNT_OPTIONS = [
        ['key' => -1, 'name' => '未設定'],
        ['key' => 0, 'name' => '横浜銀行、りそな銀行 併記'],
        ['key' => 1, 'name' => 'みずほ銀行(新規取引先向け)'],
        ['key' => 2, 'name' => 'きらぼし銀行（新規取引先向け）'],
    ];

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'contact_email',
        'department_name',
        'position_name',
        'person_in_charge',
        'contact_name',
        'contact_phone_number',
        'contact_address_1',
        'contact_address_2',
        'contact_address_3',
        'contact_postal_code',
        'aws_usage_account_id',
        'invoice_title',
        'invoice_issue_date',
        'invoice_pay_date',
        'invoice_format_type',
        'invoice_commission_fee',
        'invoice_discount_rate',
        'invoice_delivery_method',
        'is_invoice_est_enabled',
        'is_invoice_nohin_enabled',
        'bank_issuer',
        'credit_card_issuer',
        'credit_card_number',
        'notes',
    ];

    protected $hidden = [
        'awsAccount',
        'users',
        'groups',
        'settings',
        'invoiceNoticeSetting',
    ];

    public function scopeParent(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public function awsAccount()
    {
        return $this->belongsTo(AwsAccount::class, 'aws_usage_account_id', 'account_id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function invoiceNoticeSetting()
    {
        return $this->hasOne(InvoiceNoticeSetting::class);
    }

    public function settings()
    {
        return $this->hasMany(CompanySetting::class);
    }

    public function users()
    {
        return $this->hasMany(AuthUser::class);
    }
}
