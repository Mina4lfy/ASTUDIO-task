<?php

namespace App\Enum;


enum AttributeType: string
{
    case text     = \Rinvex\Attributes\Models\Type\Text::class;

    case boolean  = \Rinvex\Attributes\Models\Type\Boolean::class;

    case integer  = \Rinvex\Attributes\Models\Type\Integer::class;

    case varchar  = \Rinvex\Attributes\Models\Type\Varchar::class;

    case datetime = \Rinvex\Attributes\Models\Type\Datetime::class;

    case date     = \App\Models\EAV\Type\Date::class;

    case select   = \App\Models\EAV\Type\Select::class;

    /**
     * List all attribute types. (machine name => class name)
     *
     * @return string[]
     */
    public static function list(): array
    {
        $cases = [];

        foreach (static::cases() as $case) {
            $cases[$case->name] = $case->value;
        }

        return $cases;
    }

    /**
     * Get machine names of the availabale attribute types. eg. text/datetime/boolean.
     *
     * @return string[]
     */
    public static function machineNames(): array
    {
        return array_keys(static::list());
    }

    /**
     * Get the attribute type validation rule.
     *
     * @return string
     */
    public static function validationRule(): string
    {
        return 'in:' . implode(',', static::machineNames());
    }

    /**
     * Get the attribute type validation messages.
     *
     * @return string
     */
    public static function validationMessages(): string
    {
        return sprintf("Invalid attriibute type. Available values are: '%s'.", implode("', '", AttributeType::machineNames()));
    }
}