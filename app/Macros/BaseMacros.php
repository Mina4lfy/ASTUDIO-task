<?php

namespace App\Macros;

use ReflectionClass;
use ReflectionMethod;

abstract class BaseMacros
{
    /**
     * The class to which the macros will be registered.
     *
     * @static string
     */
    protected static string $class;

    /**
     * Register all public methods as macros.
     *
     * @return void
     */
    public static function register(): void
    {
        # Ensure $class is not empty.
        if (!static::$class) {
            throw new \Exception('The $class property must be set in the child class.');
        }

        $reflection = new ReflectionClass(static::class);

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

            # Skip the register method itself.
            if ($method->getName() === 'register') {
                continue;
            }

            # Register the method as a macro.
            static::$class::macro($method->getName(), fn(...$args) => $method->invoke(null, ...$args));
        }
    }
}