<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait Searchable
{
    /**
     * Filter eloquent query by request params.
     *
     * @param array $filters
     * @param null|array $requestParams
     * @param null|\Illuminate\Contracts\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function filter(array $filters, null|array $requestParams, ?Builder $query = null): Builder
    {
        $query ??= static::query();

        if (!$requestParams) {
            return $query;
        }

        foreach ($filters as $column => $callback) {
            if ($value = $requestParams[$column] ?? null) {

                $operator = strtolower($value['operator'] ?? 'like');
                $search = $value['value'] ?? $value;

                if ($operator === 'like') {
                    $search = "%$search%";
                }

                call_user_func($callback, $query, $search, $operator);
            }
        }

        return $query;
    }

    /**
     * Search model records by given filters.
     *
     * @param null|array $filters
     * @param null|\Illuminate\Contracts\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function search(null|array $params, ?Builder $query = null): Builder
    {
        return static::filter([], $params, $query)->orderBy('id', 'DESC');
    }
}
