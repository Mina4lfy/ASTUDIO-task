<?php

namespace App\Models\EAV;

use Rinvex\Attributes\Models\Attribute as VendorAttribute;
use App\Models\EAV\Type\Common\Option;

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
            'select'    => \App\Models\EAV\Type\Select::class,
        ]);
    }


    # relationships.

    public function options()
    {
        return $this->hasMany(Option::class);
    }


    # methods.

    /**
     * Add options for the select/radio attribute
     *
     * @param string[]|int[] $options
     * @return int
     */
    public function addOptions(array $options): int
    {
        $values = collect($options)->map(fn($value) => [
            'attribute_id' => $this->id,
            'content' => $value,
        ])->toArray();

        return $this->options()->insert($values);
    }
}