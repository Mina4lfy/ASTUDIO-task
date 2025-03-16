<?php

namespace App\Macros;

use App\Macros\BaseMacros;
use Illuminate\Support\Str;

class StrMacros extends BaseMacros
{
    /**
     * {@inheritDoc}
     */
    protected static string $class = Str::class;

    /**
     * Normalize email address: lowercase all characters and remove additional dots
     *
     * @param mixed $email
     * @return string
     */
    public static function normalizeEmail(?string $email = null)
    {
        $email = strtolower(trim($email));

        # Normalize Gmail addresses. (ignore dots)
        if (str_contains($email, '@gmail.com')) {
            [$localPart, $domain] = explode('@', $email);
            $localPart = str_replace('.', '', $localPart);
            $localPart = explode('+', $localPart)[0];
            $email = "{$localPart}@{$domain}";
        }

        return $email;
    }
}