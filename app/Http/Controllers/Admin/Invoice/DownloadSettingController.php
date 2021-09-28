<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Services\InvoiceDownloadSettingService;
use Illuminate\Http\Request;

class DownloadSettingController extends Controller
{
    private $invoiceDownloadSettingService;

    public function __construct(InvoiceDownloadSettingService $invoiceDownloadSettingService)
    {
        $this->invoiceDownloadSettingService = $invoiceDownloadSettingService;
    }

    public function index()
    {
        $settings = $this->invoiceDownloadSettingService->listSettings();

        return \Inertia::render('Admin/Invoices/Downloads/_tabs/Settings', compact('settings'));
    }

    public function update(Request $request)
    {
        if ($settings = $request->input('settings', [])) {
            $this->invoiceDownloadNoticeService->update($settings);
        }

        return back()->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }
}
