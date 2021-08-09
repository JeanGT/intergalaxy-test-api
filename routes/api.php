<?php

use Illuminate\Support\Facades\Route;

//All allowed
Route::group(
    [
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'auth'
    ],
    function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('logout', 'AuthController@logout');
        Route::get('profile', 'AuthController@profile');
        Route::post('refresh', 'AuthController@refresh');
    }
);

//Normal user only
Route::group(
    [
        'middleware' => 'role',
        'namespace' => 'App\Http\Controllers',
        'role' => ['user']
    ],
    function () {
        Route::get('receipts', 'ReceiptController@myReceipts');
    }
);

//Admin only
Route::group(
    [
        'middleware' => 'role',
        'namespace' => 'App\Http\Controllers',
        'role' => ['admin']
    ],
    function () {
        Route::get('employees', 'UserController@employees');
        Route::get('timesheets_durations', 'TimesheetController@timesheetsDurations');
        Route::post('receipts', 'ReceiptController@store');
        Route::get('generated_receipts', 'ReceiptController@generatedReceipts');
    }
);

//Normal user and admin
Route::group(
    [
        'middleware' => 'role',
        'namespace' => 'App\Http\Controllers',
        'role' => ['admin', 'user'],
    ],
    function () {
        Route::resource('timesheets', 'TimesheetController');
        Route::get('total_hours', 'TimesheetController@totalHours');
        Route::get('duplicate', 'ReceiptController@duplicate');
    }
);
