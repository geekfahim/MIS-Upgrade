<?php

use App\Http\Controllers\Base\Settings\AssetController;
use App\Http\Controllers\Base\Settings\BankController;
use App\Http\Controllers\Base\Settings\DisabilityController;
use App\Http\Controllers\Base\Settings\DisasterController;
use App\Http\Controllers\Base\Settings\DiseaseController;
use App\Http\Controllers\Base\Settings\DistrictController;
use App\Http\Controllers\Base\Settings\IncomeController;
use App\Http\Controllers\Base\Settings\OccupationController;
use App\Http\Controllers\Base\Settings\RecoverController;
use App\Http\Controllers\Base\Settings\SkillController;
use App\Http\Controllers\Base\Settings\SponsorController;
use App\Http\Controllers\Base\Settings\UnionController;
use App\Http\Controllers\Base\Settings\UpazilaController;
use App\Http\Controllers\Base\Settings\VocationalController;
use Illuminate\Support\Facades\Route;


/* Sponsor */
Route::controller(SponsorController::class)->group(function () {
    Route::get('sponsor', 'index')->name('sponsor.view');
    Route::post('sponsor-list', 'getList')->name('sponsor.view__list');
    Route::post('sponsor', 'create')->name('sponsor.create');
    Route::patch('sponsor/{id}', 'getElementById')->name('sponsor.view__one');
    Route::put('sponsor/{id}', 'update')->name('sponsor.edit');
    Route::delete('sponsor/{id}', 'delete')->name('sponsor.delete');
});

//District
Route::controller(DistrictController::class)->group(function () {
    Route::get('district', 'index')->name('district.view');
    Route::post('district-list', 'getList')->name('district.view__list');
    Route::post('district', 'create')->name('district.create');
    Route::patch('district/{id}', 'getElementById')->name('district.view__one');
    Route::put('district/{id}', 'update')->name('district.edit');
    Route::delete('district/{id}', 'delete')->name('district.delete');
});

//Upazila
Route::controller(UpazilaController::class)->group(function () {
    Route::get('upazila', 'index')->name('upazila.view');
    Route::post('upazila-list', 'getList')->name('upazila.view__list');
    Route::post('upazila', 'create')->name('upazila.create');
    Route::patch('upazila/{id}', 'getElementById')->name('upazila.view__one');
    Route::put('upazila/{id}', 'update')->name('upazila.edit');
    Route::delete('upazila/{id}', 'delete')->name('upazila.delete');
});

//Union
Route::controller(UnionController::class)->group(function () {
    Route::get('union', 'index')->name('union.view');
    Route::post('union-list', 'getList')->name('union.view__list');
    Route::post('union', 'create')->name('union.create');
    Route::patch('union/{id}', 'getElementById')->name('union.view__one');
    Route::put('union/{id}', 'update')->name('union.edit');
    Route::delete('union/{id}', 'delete')->name('union.delete');
});

/* Bank */
Route::controller(BankController::class)->group(function () {
    Route::get('bank', 'index')->name('bank.view');
    Route::post('bank-list', 'getList')->name('bank.view__list');
    Route::post('bank', 'create')->name('bank.create');
    Route::patch('bank/{id}', 'getElementById')->name('bank.view__one');
    Route::put('bank/{id}', 'update')->name('bank.edit');
    Route::delete('bank/{id}', 'delete')->name('bank.delete');
});

/* Disability */
Route::controller(DisabilityController::class)->group(function () {
    Route::get('disability', 'index')->name('disability.view');
    Route::post('disability-list', 'getList')->name('disability.view__list');
    Route::post('disability', 'create')->name('disability.create');
    Route::patch('disability/{id}', 'getElementById')->name('disability.view__one');
    Route::put('disability/{id}', 'update')->name('disability.edit');
    Route::delete('disability/{id}', 'delete')->name('disability.delete');
});

/* Occupation */
Route::controller(OccupationController::class)->group(function () {
    Route::get('occupation', 'index')->name('occupation.view');
    Route::post('occupation-list', 'getList')->name('occupation.view__list');
    Route::post('occupation', 'create')->name('occupation.create');
    Route::patch('occupation/{id}', 'getElementById')->name('occupation.view__one');
    Route::put('occupation/{id}', 'update')->name('occupation.edit');
    Route::delete('occupation/{id}', 'delete')->name('occupation.delete');
});

/* Disease */
Route::controller(DiseaseController::class)->group(function () {
    Route::get('disease', 'index')->name('disease.view');
    Route::post('disease-list', 'getList')->name('disease.view__list');
    Route::post('disease', 'create')->name('disease.create');
    Route::patch('disease/{id}', 'getElementById')->name('disease.view__one');
    Route::put('disease/{id}', 'update')->name('disease.edit');
    Route::delete('disease/{id}', 'delete')->name('disease.delete');
});

/* Income */
Route::controller(IncomeController::class)->group(function () {
    Route::get('income', 'index')->name('income.view');
    Route::post('income-list', 'getList')->name('income.view__list');
    Route::post('income', 'create')->name('income.create');
    Route::patch('income/{id}', 'getElementById')->name('income.view__one');
    Route::put('income/{id}', 'update')->name('income.edit');
    Route::delete('income/{id}', 'delete')->name('income.delete');
});

/* Asset */
Route::controller(AssetController::class)->group(function () {
    Route::get('asset', 'index')->name('asset.view');
    Route::post('asset-list', 'getList')->name('asset.view__list');
    Route::post('asset', 'create')->name('asset.create');
    Route::patch('asset/{id}', 'getElementById')->name('asset.view__one');
    Route::put('asset/{id}', 'update')->name('asset.edit');
    Route::delete('asset/{id}', 'delete')->name('asset.delete');
});

/* Disaster */
Route::controller(DisasterController::class)->group(function () {
    Route::get('disaster', 'index')->name('disaster.view');
    Route::post('disaster-list', 'getList')->name('disaster.view__list');
    Route::post('disaster', 'create')->name('disaster.create');
    Route::patch('disaster/{id}', 'getElementById')->name('disaster.view__one');
    Route::put('disaster/{id}', 'update')->name('disaster.edit');
    Route::delete('disaster/{id}', 'delete')->name('disaster.delete');
});

/* Recover */
Route::controller(RecoverController::class)->group(function () {
    Route::get('recover', 'index')->name('recover.view');
    Route::post('recover-list', 'getList')->name('recover.view__list');
    Route::post('recover', 'create')->name('recover.create');
    Route::patch('recover/{id}', 'getElementById')->name('recover.view__one');
    Route::put('recover/{id}', 'update')->name('recover.edit');
    Route::delete('recover/{id}', 'delete')->name('recover.delete');
});

/* Vocational */
Route::controller(VocationalController::class)->group(function () {
    Route::get('vocational', 'index')->name('vocational.view');
    Route::post('vocational-list', 'getList')->name('vocational.view__list');
    Route::post('vocational', 'create')->name('vocational.create');
    Route::patch('vocational/{id}', 'getElementById')->name('vocational.view__one');
    Route::put('vocational/{id}', 'update')->name('vocational.edit');
    Route::delete('vocational/{id}', 'delete')->name('vocational.delete');
});

/* Skill */
Route::controller(SkillController::class)->group(function () {
    Route::get('skill', 'index')->name('skill.view');
    Route::post('skill-list', 'getList')->name('skill.view__list');
    Route::post('skill', 'create')->name('skill.create');
    Route::patch('skill/{id}', 'getElementById')->name('skill.view__one');
    Route::put('skill/{id}', 'update')->name('skill.edit');
    Route::delete('skill/{id}', 'delete')->name('skill.delete');
});
