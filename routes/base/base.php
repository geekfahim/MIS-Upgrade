<?php

use App\Http\Controllers\Base\BaseController;
use Illuminate\Support\Facades\Route;

Route::prefix('base/request')->group(function () {
    Route::post('init', [BaseController::class, 'initData'])->name('request.jeebika.init');

    /* Report Request Start */
    Route::post('mustahiq-init', [BaseController::class, 'getMustahiqInit'])->name('reports.mustahiq.init');
    Route::post('family-init', [BaseController::class, 'getReportFamilyInit'])->name('reports.family.init');
    Route::post('gro', [BaseController::class, 'getGROByProjectId'])->name('reports.gro.list');
    Route::post('families', [BaseController::class, 'getFamiliesByProjectAndOrGRO'])->name('reports.families.search');
    /* Report Request End */
});

Route::group(['prefix' => 'base/search', 'as' => 'search.'], function () {
    Route::post('sponsor', [BaseController::class, 'sponsorSearch'])->name('sponsor.view');
    Route::post('user', [BaseController::class, 'userSearch'])->name('user.view');
    Route::post('project', [BaseController::class, 'projectSearch'])->name('project.view');
    Route::post('mustahiq', [BaseController::class, 'mustahiqSearch'])->name('mustahiq.view');
    Route::post('family', [BaseController::class, 'familySearch'])->name('family.view');
    Route::post('district', [BaseController::class, 'districtSearch'])->name('district.view');
    Route::post('upazila', [BaseController::class, 'upazilaSearch'])->name('upazila.view');
    Route::post('union', [BaseController::class, 'unionSearch'])->name('union.view');
    Route::post('bank', [BaseController::class, 'bankSearch'])->name('bank.view');
    Route::post('gro-family-head/{gid}', [BaseController::class, 'groFamilyHeadSearch'])->name('gro_family_head.view');
});

Route::get('base/notifications/{notification}', [BaseController::class, 'readNotification'])->name('notification.view');
