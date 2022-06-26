<?php

use App\Http\Controllers\Base\AllMustahiqController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'base/all-mustahiq', 'as' => 'allmustahiq.'], function () {
    //View
    Route::get('mustahiqs', [AllMustahiqController::class, 'index'])->name('information.view');
    Route::post('mustahiqs', [AllMustahiqController::class, 'viewAll'])->name('information.view__list');

    //Report
    Route::get('report', [AllMustahiqController::class, 'reportIndex'])->name('report.view');
    Route::post('report-init', [AllMustahiqController::class, 'reportInitData'])->name('report.init');
    Route::post('report', [AllMustahiqController::class, 'reportDownload'])->name('report.view__download');
    Route::post('download', [AllMustahiqController::class, 'download'])->name('information.download');
});
