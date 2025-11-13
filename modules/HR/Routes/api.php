<?php

use Illuminate\Support\Facades\Route;
use Modules\HR\Http\Controllers\DivisionController;

/*
|--------------------------------------------------------------------------
| HR Module API Routes
|--------------------------------------------------------------------------
|
| Routes for the HR (Human Resource) module.
| All routes are prefixed with /api/v1/hr
|
*/

Route::prefix('api/v1/hr')->group(function () {
    // Division routes
    Route::get('divisions/active', [DivisionController::class, 'active']);
    Route::apiResource('divisions', DivisionController::class);
});
