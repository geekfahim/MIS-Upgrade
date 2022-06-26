<?php

use App\Http\Controllers\Base\Acl\ProfileController;
use App\Http\Controllers\Base\Acl\UserController;
use App\Http\Controllers\Base\Acl\UserRoleAssignController;
use App\Http\Controllers\Base\Acl\UserRoleController;
use Illuminate\Support\Facades\Route;

/* User */
Route::controller(UserController::class)->group(function () {
    Route::get('user', 'index')->name('user.view');
    Route::post('user-list', 'getList')->name('user.view__list');
    Route::post('user', 'create')->name('user.create');
    Route::patch('user/{id}', 'getElementById')->name('user.view__one');
    Route::put('user/{id}', 'update')->name('user.edit');
    Route::delete('user/{id}', 'delete')->name('user.delete');
});

/* User Profile */
Route::get('profile', [ProfileController::class, 'index'])->name('profile.view');
Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');

/* User Role */
Route::controller(UserRoleController::class)->group(function () {
    Route::get('role', 'index')->name('role.view');
    Route::post('role-list', 'getList')->name('role.view__list');
    Route::post('role', 'create')->name('role.create');
    Route::patch('role/{id}', 'getElementById')->name('role.view__one');
    Route::put('role/{id}', 'update')->name('role.edit');
    Route::delete('role/{id}', 'delete')->name('role.delete');
});

/* User Role Assign */
Route::controller(UserRoleAssignController::class)->group(function () {
    Route::get('role-assign', 'index')->name('role_assign.view');
    Route::post('role-assign-list', 'getList')->name('role_assign.view__list');
    Route::post('role-assign', 'create')->name('role_assign.create');
    Route::patch('role-assign/{id}', 'getElementById')->name('role_assign.view__one');
    Route::put('role-assign/{id}', 'update')->name('role_assign.edit');
    Route::delete('role-assign/{id}', 'delete')->name('role_assign.delete');
});
