<?php

namespace App\Models\EAV;

use Rinvex\Attributes\Models\Attribute as VendorAttribute;
use App\Models\EAV\Type\Common\Option;
use App\Enum\AttributeType;

class Attribute extends VendorAttribute
{
    /**
     * {@inheritDoc}
     */
    public static function boot()
    {
        parent::boot();

        Attribute::typeMap(AttributeType::list());
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