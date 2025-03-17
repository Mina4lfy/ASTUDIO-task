<?php

declare(strict_types=1);

namespace App\Models\EAV\Type\Common;

use App\Models\EAV\Attribute;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
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
}
