<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Services\InvoiceDownloadHistoryService;

class DownloadHistoryController extends Controller
{
    private $invoiceDownloadHistoryService;

    public function __construct(InvoiceDownloadHistoryService $invoiceDownloadHistoryService)
    {
        $this->invoiceDownloadHistoryService = $invoiceDownloadHistoryService;
    }

    public function index()
    {
        $histories = $this->invoiceDownloadHistoryService
            ->listHistories()
            ->sortByDesc('downloaded_at')
            ->values();

        return \Inertia::render('Admin/Invoices/Downloads/_tabs/Histories', compact('histories'));
    }
}
