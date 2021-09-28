<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;

class CompanyController extends Controller
{
    /**
     *
     * @var CompanyService
     */
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        $companies = \App\Models\Company::get();

        return \Inertia::render('Admin/Companies/Index', compact('companies'));
    }

    public function show(Company $company)
    {
        $paydayOptions = Company::PAY_DAY_OPTIONS;
        $deliveryOptions = Company::DELIVERY_OPTIONS;
        $invoiceTypeOptions = Company::INVOICE_TYPE_OPTIONS;
        $invoiceDateOptions = Company::INVOICE_DATE_OPTIONS;
        $creditCardIssuer = Company::CREDIT_CARD_ISSUER;
        $bankAccountOptions = Company::BANK_ACCOUNT_OPTIONS;
        return \Inertia::render('Admin/Companies/_tabs/Form', compact(
            'company',
            'paydayOptions',
            'deliveryOptions',
            'invoiceTypeOptions',
            'invoiceDateOptions',
            'creditCardIssuer',
            'bankAccountOptions',
        ));
    }

    public function create()
    {
        $company = new Company([
            'is_invoice_est_enabled' => false,
            'is_invoice_nohin_enabled' => false,
        ]);
        $paydayOptions = Company::PAY_DAY_OPTIONS;
        $deliveryOptions = Company::DELIVERY_OPTIONS;
        $invoiceTypeOptions = Company::INVOICE_TYPE_OPTIONS;
        $invoiceDateOptions = Company::INVOICE_DATE_OPTIONS;
        $creditCardIssuer = Company::CREDIT_CARD_ISSUER;
        $bankAccountOptions = Company::BANK_ACCOUNT_OPTIONS;

        return \Inertia::render('Admin/Companies/Form', compact(
            'company',
            'paydayOptions',
            'deliveryOptions',
            'invoiceTypeOptions',
            'invoiceDateOptions',
            'creditCardIssuer',
            'bankAccountOptions',
        ));
    }

    public function store(CompanyRequest $request)
    {
        $this->companyService->create($request->input('company', []));

        return redirect(route('admin.companies.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.create'),
        ]);
    }

    public function update(Company $company, CompanyRequest $request)
    {
        $this->companyService->update($company, $request->input('company', []));

        return redirect(route('admin.companies.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function destroy(Company $company)
    {
        $this->companyService->delete($company);

        return redirect(route('admin.companies.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.delete'),
        ]);
    }
}
