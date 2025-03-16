<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

# Controllers.
use App\Http\Controllers\API\Auth\AuthController;
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

Route::middleware('api')->group(function () {

    # Loop on all directories under `routes/api`. Each subdir represents a version. (e.g. namespaced /api/v1/)
    $versionDirs = File::directories(__DIR__ . '/api');
    foreach ($versionDirs as $versionDir) {

        # Get files of each version.
        $versionFiles = File::allFiles($versionDir);
        $version = basename($versionDir);

        # Register version routes, namespaced with their verions.
        Route::prefix($version)->group(function () use ($versionFiles) {
            foreach ($versionFiles as $file) {
                include_once $file;
            }
        });
    }

});
