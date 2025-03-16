<?php

use App\Exceptions\APIExceptionHandler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        /**
         * Ensure session is started in API requests. (for Laravel Passport)
         * @see https://laracasts.com/discuss/channels/laravel/sanctum-throws-session-store-not-set-on-request?page=1&replyId=871059
         * @see https://stackoverflow.com/questions/34449770/laravel-session-store-not-set-on-request/35393714#35393714
         */
        $middleware->api([
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ]);

        /**
         * Stop validating CSRF tokens in API endpoints. We may need it when exposed to mobile apps.
         * $middleware->validateCsrfTokens([
         *     '/api/*'
         * ]);
         */

    })
    ->withExceptions(function (Exceptions $exceptions) {

        # Handler API errors.
        if (request()->is('api/*')) {
            app(APIExceptionHandler::class)->register($exceptions);
        }

    })->create();
