<?php

namespace App\Services;

use App\Models\InvoiceDownloadHistory;

class InvoiceDownloadHistoryService extends EloquentModelService
{
    public function listHistories(string $ym = null)
    {
        $query = InvoiceDownloadHistory::with([
            'user:id,name,email,company_id',
            'user.company:id,company_name,contact_email'
        ]);
        if ($ym) {
            $query->where('ym', $ym);
        }

        return $query->get()->map(function ($item) {
            $item->user_info = $item->user->only('name', 'email');
            $item->company_info = $item->user->company->only('company_name', 'contact_email');

            return $item;
        });
    }
}
