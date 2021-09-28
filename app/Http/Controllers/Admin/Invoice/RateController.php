<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\RateRequest;
use App\Models\ExchangeRate;
use App\Services\ExchangeRateService;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * @var ExchangeRateService
     */
    private $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function index()
    {
        $rates = $this->exchangeRateService
            ->list()
            ->sortByDesc('ym')
            ->values();

        return \Inertia::render('Admin/Invoices/Rates/Index', compact('rates'));
    }

    public function create()
    {
        $rate = new ExchangeRate();

        return \Inertia::render('Admin/Invoices/Rates/Form', compact('rate'));
    }

    public function store(RateRequest $request)
    {
        $this->exchangeRateService->create($request->input('invoice.rate', []));

        return redirect(route('admin.invoices.rates.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.create'),
        ]);
    }


    public function edit(ExchangeRate $rate)
    {
        return \Inertia::render('Admin/Invoices/Rates/Form', compact('rate'));
    }

    public function update(ExchangeRate $rate, RateRequest $request)
    {
        $this->exchangeRateService->update($rate, $request->input('invoice.rate', []));

        return redirect(route('admin.invoices.rates.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function destroy(ExchangeRate $rate)
    {
        $this->exchangeRateService->delete($rate);

        return redirect(route('admin.invoices.rates.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.delete'),
        ]);
    }
}
