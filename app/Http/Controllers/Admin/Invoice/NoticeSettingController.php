<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Services\InvoiceNoticeSettingService;
use Illuminate\Http\Request;

class NoticeSettingController extends Controller
{
    /**
     * @var InvoiceNoticeSettingService
     */
    private $invoiceNoticeSettingService;

    public function __construct(InvoiceNoticeSettingService $invoiceNoticeSettingService)
    {
        $this->invoiceNoticeSettingService = $invoiceNoticeSettingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = $this->invoiceNoticeSettingService
            ->listSettings()
            ->sortBy('company_name')
            ->values();

        return \Inertia::render('Admin/Invoices/Settings/Notices/Index', compact('settings'));
    }

    public function update(Request $request)
    {
        if ($settings = $request->input('settings', [])) {
            $this->invoiceNoticeSettingService->updateSettings($settings);
        }

        return back()->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }
}
