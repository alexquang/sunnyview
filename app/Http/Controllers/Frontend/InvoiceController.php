<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\InvoiceService;

class InvoiceController extends Controller
{
    /**
     * @var InvoiceService
     */
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        $invoices = $this->invoiceService->list([
            'id',
            'ym',
            'company_name',
            'contact_email',
        ]);

        return \Inertia::render('Frontend/Invoices/Index', compact('invoices'));
    }
}
