<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Project\ProjectsController;

/*
|--------------------------------------------------------------------------
| API Projects Routes
|--------------------------------------------------------------------------
|
| The following routes are included in the `routes/api.php` routes under
| `api/v1` namespace.
|
*/

# Guarded by API auth.
Route::middleware('auth:api')->group(function () {

    # Projects.
    Route::apiResource('projects', ProjectsController::class);

});
