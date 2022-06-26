<?php

use App\Http\Controllers\Jeebika\Reports\FamilyReportController;
use App\Http\Controllers\Jeebika\Reports\GroReportController;
use App\Http\Controllers\Jeebika\Reports\MustahiqReportController;
use App\Http\Controllers\Jeebika\Reports\ProjectReportController;
use App\Http\Controllers\Jeebika\Reports\StatisticController;
use App\Http\Controllers\Jeebika\Reports\HealthSessionReportController;
use App\Http\Controllers\Jeebika\Reports\TrainingReportController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'jeebika/reports', 'as' => 'reports.'], function () {
    /*Statistic*/
    Route::get('statistic', [StatisticController::class, 'index'])->name('statistic.view');
    Route::post('statistic', [StatisticController::class, 'getAll'])->name('statistic.list');
    /*Training*/
    Route::get('training', [TrainingReportController::class, 'index'])->name('training.view');
    Route::post('training', [TrainingReportController::class, 'download'])->name('training.create');
    Route::post('project-training', [TrainingReportController::class, 'getTrainingByProjectId'])->name('training.list');
    /*Health Session*/
    Route::get('health-session', [HealthSessionReportController::class, 'index'])->name('health_session.view');
    Route::post('health-session', [HealthSessionReportController::class, 'download'])->name('health_session.create');
    Route::post('project-health-session', [HealthSessionReportController::class, 'getTrainingByProjectId'])->name('health_session.list');
    /* Family */
    Route::get('family', [FamilyReportController::class, 'index'])->name('family.view');
    Route::post('family', [FamilyReportController::class, 'download'])->name('family.create');
    /* GRO */
    Route::get('gro', [GroReportController::class, 'index'])->name('gro.view');
    Route::post('gro', [GroReportController::class, 'download'])->name('gro.create');
    /* Project */
    Route::get('project', [ProjectReportController::class, 'index'])->name('project.view');
    Route::post('project', [ProjectReportController::class, 'download'])->name('project.create');
    /* Mustahiq */
    Route::get('mustahiq', [MustahiqReportController::class, 'index'])->name('mustahiq.view');
    Route::post('mustahiq', [MustahiqReportController::class, 'download'])->name('mustahiq.create');
});
