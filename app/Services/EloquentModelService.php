<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

abstract class EloquentModelService
{
    /**
     * @var string
     */
    private $modelClass;

    /**
     * @var array
     */
    private $queryScopes = [];

    /**
     * @var array
     */
    private $queryCounts = [];

    /**
     * @var string
     */
    private $cacheKey;

    /**
     * Deligate queries to this function to avoid code duplication
     */
    protected function listUsing(
        Relation|Builder $query,
        array $columns = ['*'],
        array $conditions = []
    ): Collection {
        return $query
            ->select($columns)
            ->withCount($this->queryCounts)
            ->scopes($this->queryScopes)
            ->where($conditions)
            ->get();
    }

    public function list(array $columns = ['*'], array $conditions = []): Collection
    {
        return $this->listUsing($this->makeQuery(), $columns, $conditions);
    }

    public function listByIds(array $ids, array $columns = ['*']): Collection
    {
        return $this->listUsing(
            $this->makeQuery()->whereIn('id', $ids),
            $columns
        );
    }

    public function withScopes(array $queryScopes): static
    {
        $this->queryScopes = $queryScopes;

        return $this;
    }

    public function withCounts(array $relations): static
    {
        $this->queryCounts = $relations;

        return $this;
    }

    public function fromCache($cacheKey)
    {
        $this->cacheKey = $cacheKey;

        return $this;
    }

    protected function makeQuery(): Builder
    {
        if (!$this->modelClass && preg_match('/.+\\\(.+)Service$/', get_called_class(), $matches)) {
            $this->modelClass = "\\App\Models\\{$matches[1]}";
        }

        return $this->modelClass::query();
    }
}
