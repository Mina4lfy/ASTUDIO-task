<?php

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Validation\ValidationException;

class APIExceptionHandler
{
    public function register(Exceptions $exceptions): void
    {
        $this->handleAuthenticationException($exceptions);
        $this->handleAuthorizationExceptions($exceptions);
        $this->handleNotFoundExceptions($exceptions);
        $this->handleValidationExceptions($exceptions);
    }

    protected function handleAuthenticationException(Exceptions $exceptions): void
    {
        $exceptions->render(fn(AuthenticationException $e) => $this->renderErrorResponse(
            $e,
            Response::HTTP_UNAUTHORIZED,
            'Unauthenticated',
            'Authentication is required to access this resource.',
        ));
    }

    protected function handleAuthorizationExceptions(Exceptions $exceptions): void
    {
        $statusCode = Response::HTTP_FORBIDDEN;
        $errorKey = 'Forbidden';
        $errorMsg = 'You are not authorized to perform this action.';

        $exceptions->render(fn(AuthorizationException $e) => $this->renderErrorResponse($e, $statusCode, $errorKey, $errorMsg));
        $exceptions->render(fn(AccessDeniedHttpException $e) => $this->renderErrorResponse($e, $statusCode, $errorKey, $errorMsg));
    }

    protected function handleNotFoundExceptions(Exceptions $exceptions): void
    {
        $exceptions->render(function (NotFoundHttpException $e) {

            # Attempt to extract the original ModelNotFoundException if possible.
            $previous = $e->getPrevious();
            if ($previous instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return $this->renderErrorResponse(
                    $e,
                    Response::HTTP_NOT_FOUND,
                    'Resource Not Found.',
                    "The requested resource does not exist.",
                );
            }

            # Invalid URL/endpoint.
            return $this->renderErrorResponse(
                $e,
                Response::HTTP_NOT_FOUND,
                'Not Found',
                "The requested endpoint could not be found.",
            );
        });
    }

    protected function handleValidationExceptions(Exceptions $exceptions): void
    {
        $exceptions->render(fn(ValidationException $e) => $this->renderErrorResponse(
            $e,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            'Validation Error',
            fn($e) => $e->errors()
        ));
    }

    protected function renderErrorResponse(mixed $e, int $statusCode, string $errorKey = '', string|callable $message = ''): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'error' => $errorKey,
            'message' => value($message, $e),
        ], $statusCode);
    }
}