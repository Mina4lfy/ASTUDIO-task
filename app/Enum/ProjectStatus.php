<?php

namespace App\Enum;

enum ProjectStatus: string
{
    case PENDING = 'pending';

    case IN_PROGRESS = 'in-progress';

    case FINISHED = 'finished';

    case ARCHIVED = 'archived';

    /**
     * List all attribute types. (machine name => class name)
     *
     * @return string[]
     */
    public static function list(): array
    {
        $cases = [];

        foreach (static::cases() as $case) {
            $cases[] = $case->value;
        }

        return $cases;
    }

    /**
     * Get the attribute type validation rule.
     *
     * @return string
     */
    public static function validationRule(): string
    {
        return 'in:' . implode(',', static::list());
    }
}