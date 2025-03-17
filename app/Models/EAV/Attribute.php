<?php

namespace App\Models\EAV;

# models.
use Rinvex\Attributes\Models\Attribute as VendorAttribute;
use App\Models\EAV\Type\Common\Option;

# enums.
use App\Enum\AttributeType;

# eloquent.
use Illuminate\Database\Eloquent\Builder;

# traits.
use App\Traits\Searchable;

class Attribute extends VendorAttribute
{
    use Searchable;

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


    # search

    /**
     * {@inheritDoc}
     */
    public static function search(null|array $params, ?Builder $query = null): Builder
    {
        return static::filter([

            'name'          => fn($q, $value) => $q->where('name', 'like', "%$value%"),

            'slug'          => fn($q, $value) => $q->where('slug', 'like', "%$value%"),

            'type'          => fn($q, $value) => $q->where('type', 'like', "%$value%"),

            'description'   => fn($q, $value) => $q->where('description', 'like', "%$value%"),

        ], $params, $query)->orderBy('id', 'DESC');
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