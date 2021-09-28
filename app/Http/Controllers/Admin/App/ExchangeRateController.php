<?php

namespace App\Http\Controllers\Admin\App;

use App\Models\ExchangeRate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\RateRequest;
use App\Services\ExchangeRateService;

class ExchangeRateController extends Controller
{
    private $rateService;

    public function __construct(ExchangeRateService $rateService)
    {
        $this->rateService = $rateService;
    }

    public function index()
    {
        $rates = $this->rateService->list()->map(function ($rate) {
            $year = substr($rate->ym, 0, 4);
            $month = substr($rate->ym, 4, 2);
            $appendYM = $year.'/'.$month;
            $rate->ym = $appendYM;
            return $rate;
        })->sortByDesc('ym')->values();

        return \Inertia::render('Admin/App/ExchangeRates/Index', compact('rates'));
    }

    public function create()
    {
        $rate = new ExchangeRate();

        return \Inertia::render('Admin/App/ExchangeRates/Form', compact('rate'));
    }

    public function store(RateRequest $request)
    {
        $this->rateService->create($request->input('app.rate', []));

        return redirect(route('admin.app.rates.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.create'),
        ]);
    }

    public function edit(ExchangeRate $rate)
    {
        return \Inertia::render('Admin/App/ExchangeRates/Form', compact('rate'));
    }

    public function update(ExchangeRate $rate, RateRequest $request)
    {
        $this->rateService->update($rate, $request->input('app.rate', []));

        return redirect(route('admin.app.rates.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function destroy(ExchangeRate $rate)
    {
        $this->rateService->delete($rate);

        return redirect(route('admin.app.rates.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.delete'),
        ]);
    }
}
