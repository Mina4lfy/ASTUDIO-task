<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Auth Routes
|--------------------------------------------------------------------------
|
| The following routes are included in the `routes/api.php` routes under
| `api/v1` namespace.
|
*/

# Auth. (public ~ user is not authenticated yet)
Route::prefix('auth')->group(function () {

    Route::post('register', [AuthController::class, 'register']);

    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {

        Route::post('logout', [AuthController::class, 'logout']);

    });

});
