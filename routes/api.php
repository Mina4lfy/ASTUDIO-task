<?php

use Illuminate\Support\Facades\Route;

# Controllers.
use App\Http\Controllers\API\Project\ProjectsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

# Version 1.
Route::prefix('v1')->group(function () {

    # Guarded by auth.
    // Route::middleware('auth:api')->group(function () {

    # Projects.
    Route::apiResource('projects', ProjectsController::class);
    // });
});
