<?php

namespace App\Services;

use App\Models\ExchangeRate;

class ExchangeRateService extends EloquentModelService
{
    public function create(array $data): ExchangeRate
    {
        $rate = new ExchangeRate();

        $rate->fill($data)->save();

        return $rate->fresh();
    }

    public function update(ExchangeRate $rate, array $data): ExchangeRate
    {
        $rate->fill($data)->save();

        return $rate->fresh();
    }

    public function delete(ExchangeRate $rate): ExchangeRate
    {
        $rate->delete();

        return $rate->fresh();
    }
}
