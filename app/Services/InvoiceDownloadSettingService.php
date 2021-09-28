<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceDownloadSetting;
use Illuminate\Database\Eloquent\Collection;

class InvoiceDownloadSettingService extends EloquentModelService
{
    public function listSettings(): Collection
    {
        return Invoice::select([
            'id',
            'ym',
            'aws_usage_account_id',
            'company_name',
            'contact_email',
            'invoice_delivery_method',
        ])
            ->with([
                'downloadSetting:invoice_id,is_notifiable',
                'awsAccount:account_id,account_name',
            ])
            ->withCount('downloadHistories')
            ->get()->map(function ($item) {
                $item->invoice_id = $item->id;
                $item->is_notifiable = $item->downloadSetting->is_notifiable ?? true;
                $item->is_settingable = $item->invoice_delivery_method != 'post' && $item->download_histories_count == 0;

                return $item;
            });
    }

    public function update(array $data)
    {
        return \DB::transaction(function () use ($data) {
            $result = array_filter($data, function ($key) use ($data) {
                return $data[$key]['is_notifiable'] == false;
            }, ARRAY_FILTER_USE_KEY);

            InvoiceDownloadSetting::truncate();

            InvoiceDownloadSetting::insert($result);
        });
    }
}
