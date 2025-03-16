<?php

declare(strict_types=1);

namespace App\Models\EAV\Type;

use Rinvex\Attributes\Models\Value;
use App\Models\EAV\Type\Common\Option;

/**
 * Rinvex\Attributes\Models\Type\Text.
 *
 * @property int                 $id
 * @property string              $content
 * @property int                 $attribute_id
 * @property int                 $entity_id
 * @property string              $entity_type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Rinvex\Attributes\Models\Attribute           $attribute
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $entity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EAV\Type\Select whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EAV\Type\Select whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EAV\Type\Select whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EAV\Type\Select whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EAV\Type\Select whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EAV\Type\Select whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EAV\Type\Select whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Select extends Value
{
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'attribute_id'  => 'integer',
        'entity_id'     => 'integer',
        'entity_type'   => 'string',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('rinvex.attributes.tables.attribute_select_values'));

        $this->mergeRules([
            'content'       => 'required', // |string|exists:' . config('rinvex.attributes.tables.attributes_options') . ',id',
            'attribute_id'  => 'required|integer|exists:' . config('rinvex.attributes.tables.attributes') . ',id',
            'entity_id'     => 'required|integer',
            'entity_type'   => 'required|string|strip_tags|max:150',
        ]);

        parent::__construct($attributes);
    }


    # mutators.

    /**
     * Update `content` to be the referenced option `content` instead of its `id`.
     *
     * @param string $content
     */
    public function getContentAttribute(null|string|int $content): ?string
    {
        // return is_numeric($content) ? $this->option?->content : $content;
        return is_numeric($content) ? Option::find($content)?->content : $content;
    }


    # relationships.

    public function option()
    {
        return $this->hasOne(Option::class, 'id', 'content');
    }
}
