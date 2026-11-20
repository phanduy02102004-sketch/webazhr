<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AZMedia\AZMediaApiController;

/*
|--------------------------------------------------------------------------
| API Routes for AZ Media Internship Recruitment System
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // 1. Careers & Positions APIs
    Route::get('/positions', [AZMediaApiController::class, 'getPositions']);
    Route::get('/positions/{id}', [AZMediaApiController::class, 'getPositionDetail']);
    Route::post('/apply', [AZMediaApiController::class, 'submitApply']);

    // 2. Candidate Portal APIs
    Route::get('/candidate/track/{key}', [AZMediaApiController::class, 'trackProgress']);
    Route::get('/candidate/test/{code}', [AZMediaApiController::class, 'getTestQuestions']);

    // 3. Mini-ATS Analytics API
    Route::get('/ats/analytics', [AZMediaApiController::class, 'getAnalytics']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
