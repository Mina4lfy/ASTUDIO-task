<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Request;

trait ModelHasSearch
{
    /**
     * Filter eloquent query by request params.
     *
     * @param array $filters
     * @param null|array $requestParams
     * @param null|\Illuminate\Database\Eloquent\Builder $query
     * @return Builder
     */
    public static function filter(array $filters, null|array $requestParams, ?Builder $query = null): Builder
    {
        $query ??= static::query();

        if (!$requestParams) {
            return $query;
        }

        foreach ($filters as $column => $callback) {
            if ($value = $requestParams[$column] ?? null) {
                call_user_func($callback, $query, $value);
            }
        }

        return $query;
    }

    /**
     * Filter eloquent query by request params
     *
     * @param \App\Http\Requests\Request $request
     * @param array $filters
     * @param null|\Illuminate\Database\Eloquent\Builder $query
     * @return Builder
     */
    public static function filterByRequest(Request $request, array $filters, ?Builder $query = null): Builder
    {
        $filters = (array) ($request->filter ?? []);

        return static::filter($filters, (array) $request->filter ?? [], $query);
    }

    /**
     * Search model records by given filters.
     *
     * @param null|array $filters
     * @param mixed $query
     */
    public static function search(null|array $params, ?Builder $query = null): Builder
    {
        return static::filter([], $params, $query)->orderBy('id', 'DESC');
    }
}
