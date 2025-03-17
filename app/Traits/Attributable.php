<?php

namespace App\Traits;

use \Rinvex\Attributes\Traits\Attributable as VendorAttributable;

trait Attributable
{
    use VendorAttributable;

    /**
     * Get dynamic attribute slugs, mapped to their values.
     *
     * @return array
     */
    public function getDynamicAttributes(): array
    {
        $attributes = [];

        $this->getEntityAttributes()
            ->pluck('slug')
            ->each(function ($key) use (&$attributes) {
                $attributes[$key] = $this->{$key} ?? null;
            });

        return $attributes;
    }
}
