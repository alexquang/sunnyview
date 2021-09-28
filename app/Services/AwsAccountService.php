<?php

namespace App\Services;

use App\Models\AwsAccount;

class AwsAccountService extends EloquentModelService
{
    public function create(array $data): AwsAccount
    {
        $account = new AwsAccount();

        $account->fill($data)->save();

        return $account->fresh();
    }

    public function update(AwsAccount $account, array $data): AwsAccount
    {
        $account->fill($data)->save();

        return $account->fresh();
    }

    public function delete(AwsAccount $account): AwsAccount
    {
        $account->delete();

        return $account->fresh();
    }
}
