<?php

namespace App\Models\EAV;

use Rinvex\Attributes\Models\Attribute as VendorAttribute;

class Attribute extends VendorAttribute
{
    /**
     * {@inheritDoc}
    */
    public static function boot()
    {
        parent::boot();

        Attribute::typeMap([
            'text'      => \Rinvex\Attributes\Models\Type\Text::class,
            'boolean'   => \Rinvex\Attributes\Models\Type\Boolean::class,
            'integer'   => \Rinvex\Attributes\Models\Type\Integer::class,
            'varchar'   => \Rinvex\Attributes\Models\Type\Varchar::class,
            'datetime'  => \Rinvex\Attributes\Models\Type\Datetime::class,
            'date'      => \App\Models\EAV\Type\Date::class,
        ]);
    }
}