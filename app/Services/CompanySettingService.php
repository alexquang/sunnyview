<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanySetting;

class CompanySettingService extends EloquentModelService
{
    public function listSettings(Company $company, array $keys = [])
    {
        $settings = $company
            ->settings()
            ->whereIn('key', $keys ?: array_keys(CompanySetting::KEYS))
            ->get()
            ->keyBy('key')
            ->map(fn ($item) => $item->value)
            ->toArray();

        $settingItems = [];
        foreach ($keys as $key) {
            $settingItems[] = [
                'key' => $key,
                'value' => array_key_exists($key, $settings) ? $settings[$key] : CompanySetting::KEYS[$key],
            ];
        }

        return $settingItems;
    }

    public function update(Company $company, array $data)
    {
        $company->settings()->upsert($data, ['company_id', 'key'], ['value']);
    }
}
