<?php

declare(strict_types=1);

return [

    // Manage autoload migrations
    'autoload_migrations' => true,

    // Attributes Database Tables
    'tables' => [

        'attributes' => 'attributes',
        'attribute_entity' => 'attribute_entity',
        'attribute_boolean_values' => 'attribute_boolean_values',
        'attribute_datetime_values' => 'attribute_datetime_values',
        'attribute_integer_values' => 'attribute_integer_values',
        'attribute_text_values' => 'attribute_text_values',
        'attribute_varchar_values' => 'attribute_varchar_values',

    ],

    // Attributes Models
    'models' => [

        'attribute' => \App\Models\EAV\Attribute::class,
        'attribute_entity' => \App\Models\EAV\AttributeEntity::class,

    ],

];
