<?php

use App\Http\Controllers\Jeebika\Settings\JAreaController;
use App\Http\Controllers\Jeebika\Settings\JIndicatorController;
use App\Http\Controllers\Jeebika\Settings\JInvestmentAreaController;
use App\Http\Controllers\Jeebika\Settings\JZoneController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'jeebika/settings', 'as' => 'settings.'], function () {
    //Indicator
    Route::get('indicator', [JIndicatorController::class, 'index'])->name('indicator.view');
    Route::post('indicator-list', [JIndicatorController::class, 'getList'])->name('indicator.view__list');
    Route::post('indicator', [JIndicatorController::class, 'create'])->name('indicator.create');
    Route::patch('indicator/{id}', [JIndicatorController::class, 'getElementById'])->name('indicator.view__one');
    Route::put('indicator/{id}', [JIndicatorController::class, 'update'])->name('indicator.edit');
    Route::delete('indicator/{id}', [JIndicatorController::class, 'delete'])->name('indicator.delete');

    Route::get('zone', [JZoneController::class, 'index'])->name('zone.view');
    Route::post('zone-list', [JZoneController::class, 'getList'])->name('zone.view__list');
    Route::post('zone', [JZoneController::class, 'create'])->name('zone.create');
    Route::patch('zone/{id}', [JZoneController::class, 'getElementById'])->name('zone.view__one');
    Route::put('zone/{id}', [JZoneController::class, 'update'])->name('zone.edit');
    Route::delete('zone/{id}', [JZoneController::class, 'delete'])->name('zone.delete');

    Route::get('area', [JAreaController::class, 'index'])->name('area.view');
    Route::post('area-list', [JAreaController::class, 'getList'])->name('area.view__list');
    Route::post('area', [JAreaController::class, 'create'])->name('area.create');
    Route::patch('area/{id}', [JAreaController::class, 'getElementById'])->name('area.view__one');
    Route::put('area/{id}', [JAreaController::class, 'update'])->name('area.edit');
    Route::delete('area/{id}', [JAreaController::class, 'delete'])->name('area.delete');

    //Business Plan Investment Area
    Route::get('investment-area', [JInvestmentAreaController::class, 'index'])->name('investment_area.view');
    Route::post('investment-area', [JInvestmentAreaController::class, 'create'])->name('investment_area.create');
    Route::patch('investment-area/{id}', [JInvestmentAreaController::class, 'getElementById'])->name('investment_area.one');
    Route::put('investment-area/{id}', [JInvestmentAreaController::class, 'update'])->name('investment_area.edit');
    Route::delete('investment-area/{id}', [JInvestmentAreaController::class, 'delete'])->name('investment_area.delete');
    //On search list
    Route::post('investment-area-list', [JInvestmentAreaController::class, 'getList'])->name('investment_area.list');
});
