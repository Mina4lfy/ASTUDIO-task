<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Attribute\AttributesController;

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

    # Attributes.
    Route::apiResource('attributes', AttributesController::class);

});
