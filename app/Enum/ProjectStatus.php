<?php

namespace App\Enum;

enum ProjectStatus: string
{
    case PENDING = 'pending';

    case IN_PROGRESS = 'in-progress';

    case FINISHED = 'finished';

    case ARCHIVED = 'archived';

    public static function list(): array
    {
        $cases = [];

        foreach (static::cases() as $case) {
            $cases[] = $case->value;
        }

        return $cases;
    }

    public static function validationRule(): string
    {
        return 'in:' . implode(',', static::list());
    }
}