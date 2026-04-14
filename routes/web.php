<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'VisualizerController@index')->name('index');
Route::get('/data', 'VisualizerController@data')->name('data');
Route::get('/detail/{model}', 'VisualizerController@detail')->name('detail');
Route::post('/cache-clear', 'VisualizerController@clearCache')->name('clear-cache');
