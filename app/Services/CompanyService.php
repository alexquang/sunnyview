<?php

namespace App\Services;

use App\Models\Company;

class CompanyService extends EloquentModelService
{
    public function create(array $data): Company
    {
        $company = new Company();
        $company->fill($data);
        $company->save();

        return $company->fresh();
    }

    public function update(Company $company, array $data): Company
    {
        $company->fill($data)->save();

        return $company->fresh();
    }

    public function delete(Company $company)
    {
        $company->delete();

        return $company->fresh();
    }
}
