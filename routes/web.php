<?php
use Illuminate\Support\Facades\Route;
use Naimul\DbVisualizer\Http\Controllers\VisualizerController;

Route::prefix('dbv')->group(function () {
    Route::get('/', [VisualizerController::class, 'index']);
    Route::get('/data', [VisualizerController::class, 'data']);
    Route::get('/detail/{model}', [VisualizerController::class, 'detail']);
});