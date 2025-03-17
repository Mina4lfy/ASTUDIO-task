<?php

declare(strict_types=1);

namespace App\Models\EAV\Type\Common;

# models.
use App\Models\BaseModel;
use App\Models\EAV\Attribute;

# eloquent.
use Illuminate\Contracts\Database\Query\Builder;

class Option extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'content',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'attribute_id' => 'integer',
    ];


    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('rinvex.attributes.tables.attributes_options'));

        parent::__construct($attributes);
    }


    # relationships.

    /**
     * Relationship to parent attribute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Attribute, Option>
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }


    # search

    /**
     * {@inheritDoc}
     */
    public static function search(null|array $params, ?Builder $query = null): Builder
    {
        return static::filter([

            'content' => fn($q, $value) => $q->where('content', 'like', "%$value%"),

        ], $params, $query)->orderBy('id', 'DESC');
    }
}
