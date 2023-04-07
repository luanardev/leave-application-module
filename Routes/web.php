<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('leave_application')->middleware(['auth', 'client:leaveapplication'])->group(function () {

    Route::get('/', 'HomeController@index')->name('leave_application.home');
    Route::get('applications', 'LeaveController@index')->name('leave_application.index');
    Route::get('apply_for_leave', 'LeaveController@apply')->name('leave_application.apply');
    Route::get('return_from_leave', 'LeaveController@pendingReturns')->name('leave_application.returning');
    Route::get('leave/{leave}/return', 'LeaveController@returnBack')->name('leave_application.returnback');
    Route::get('application/{leaveType}/create', 'LeaveController@create')->name('leave_application.create');
    Route::get('application/{leave}/show', 'LeaveController@show')->name('leave_application.show');
    Route::get('application/{leave}/edit', 'LeaveController@edit')->name('leave_application.edit');
    Route::get('application/{leave}/approve', 'LeaveController@approve')->name('leave_application.approve');

});
