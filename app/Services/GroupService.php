<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Group;

class GroupService extends EloquentModelService
{
    public function listByCompany(Company $company, array $columns = ['*']): Collection
    {
        return $this->listUsing($company->groups(), $columns);
    }

    public function create(array $data): Group
    {
        $group = new Group();
        $group->fill($data)->save();

        return $group->fresh();
    }

    public function update(Group $group, array $data): Group
    {
        $group->fill($data)->save();

        return $group->fresh();
    }

    public function delete(Group $group): Group
    {
        $group->delete();

        return $group->fresh();
    }
}
