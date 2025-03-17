<?php

namespace App\Traits;

trait PaginatableRequest
{
    /**
     * Default `per_page` if not provided in the request
     *
     * @var int
     */
    protected const DEFAULT_PER_PAGE = 10;

    /**
     * Prepare request for validation.
     * 
     * @return void
     */
    protected function preparePaginatableRequestForValidation()
    {
        $this->merge([
            'page' => $this->page ?? 1,
            'per_page' => $this->per_page ?? static::DEFAULT_PER_PAGE,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function getPaginatableRequestRules()
    {
        return [
            'page' => [
                'nullable',
                'numeric',
                'min:1',
            ],
            'per_page' => [
                'nullable',
                'numeric',
                'max:100',
            ],
        ];
    }
}
