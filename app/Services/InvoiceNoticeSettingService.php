<?php

namespace App\Services;

use App\Models\Company;
use App\Models\InvoiceNoticeSetting;
use Illuminate\Database\Eloquent\Collection;

class InvoiceNoticeSettingService extends EloquentModelService
{
    public function listSettings(): Collection
    {
        return Company::parent()->with([
            'invoiceNoticeSetting:company_id,is_notifiable',
            'awsAccount:account_id,account_name',
        ])->select([
            'id', // must have for relation `invoiceNoticeSetting` to work
            'company_name',
            'contact_email',
            'aws_usage_account_id', // must have for relation `awsAccount` to work
        ])->get()->map(function ($item) {
            $item->account_id = $item->awsAccount->account_id ?? null;
            $item->account_name = $item->awsAccount->account_name ?? null;

            $item->is_notifiable = $item->invoiceNoticeSetting->is_notifiable ?? true;

            return $item;
        });
    }

    public function updateSettings(array $data)
    {
        \DB::transaction(function () use ($data) {
            InvoiceNoticeSetting::truncate();

            InvoiceNoticeSetting::insert($data);
        });
    }
}
