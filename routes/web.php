<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/connections/accept/{id}', [ConnectionController::class, 'accept'])->name('connections.accept');
    Route::post('/connections/reject/{id}', [ConnectionController::class, 'reject'])->name('connections.reject');
    Route::post('/connections/send/{id}', [ConnectionController::class, 'send'])->name('connections.send');

    Route::post('/send-message', [ChatController::class, 'sendMessage']);
    Route::get('/home/{friendId}', [DashboardController::class, 'showHome'])->name('home.show');


    Route::get('/group/{groupId}', [DashboardController::class, 'groupChat'])->name('group.chat');
    Route::post('/groups/{group}/add-user', [GroupController::class, 'addUser'])->name('group.join');

});
Route::middleware('auth')->post('/broadcasting/auth', function () {
    return Broadcast::auth(request());
});
