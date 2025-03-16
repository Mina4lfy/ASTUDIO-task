<?php

declare(strict_types=1);

namespace App\Models\EAV\Type;

use Rinvex\Attributes\Models\Value;

/**
 * Rinvex\Attributes\Models\Type\Date.
 *
 * @property int                 $id
 * @property \Carbon\Carbon      $content
 * @property int                 $attribute_id
 * @property int                 $entity_id
 * @property string              $entity_type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Rinvex\Attributes\Models\Attribute           $attribute
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $entity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Attributes\Models\Type\Date whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Attributes\Models\Type\Date whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Attributes\Models\Type\Date whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Attributes\Models\Type\Date whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Attributes\Models\Type\Date whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Attributes\Models\Type\Date whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Attributes\Models\Type\Date whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Date extends Value
{
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'content' => 'date',
        'attribute_id' => 'integer',
        'entity_id' => 'integer',
        'entity_type' => 'string',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('rinvex.attributes.tables.attribute_date_values'));

        $this->mergeRules([
            'content' => 'required|date',
            'attribute_id' => 'required|integer|exists:' . config('rinvex.attributes.tables.attributes') . ',id',
            'entity_id' => 'required|integer',
            'entity_type' => 'required|string|strip_tags|max:150',
        ]);

        parent::__construct($attributes);
    }
}
