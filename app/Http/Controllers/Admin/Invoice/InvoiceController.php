<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

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
        $invoices =  $this->invoiceService->list();

        return \Inertia::render('Admin/Invoices/Index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        return \Inertia::render('Admin/Invoices/_tabs/Form', compact('invoice'));
    }
}
