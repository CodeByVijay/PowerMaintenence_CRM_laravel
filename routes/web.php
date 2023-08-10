<?php

use App\Http\Controllers\authentications\HomeController;
use App\Http\Controllers\dashboard\HomeController as DashboardHomeController;
use App\Http\Controllers\leads\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\retailer\RetailerController;
use App\Http\Controllers\users\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

$controller_path = 'App\Http\Controllers';

// Main Page Route
Route::get('/', [HomeController::class, 'login'])->name('login');
Route::post('/login', [HomeController::class, 'loginPost'])->name('loginPost');
Route::get('/auth/forgot-password', [HomeController::class, 'forgotPass'])->name('forgotPass');
Route::post('/auth/forgot-password', [HomeController::class, 'forgotPassPost'])->name('forgotPassPost');
Route::get('/auth/reset-password/{token}', [HomeController::class, 'reset_password_view'])->name('reset_password');
Route::post('/auth/reset-password', [HomeController::class, 'reset_password_post'])->name('reset_password_post');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardHomeController::class, 'index'])->name('dashboard');
    Route::get('/my-profile', [ProfileController::class, 'index'])->name('my-profile');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('update-profile');

    Route::group(['prefix' => 'user', 'middleware' => 'useraccess'], function () {
        Route::get('/create-new', [UsersController::class, 'index'])->name('user-create-new');
        Route::post('/create-user', [UsersController::class, 'createUser'])->name('createUser');
        Route::get('/users-list', [UsersController::class, 'users'])->name('user-users-list');
        Route::get('/users-list-get', [UsersController::class, 'userList'])->name('userList');
        Route::post('/user-status-change', [UsersController::class, 'userStatusChange'])->name('userStatusChange');
        Route::post('/user-delete', [UsersController::class, 'userDelete'])->name('userDelete');

        Route::get('/edit/{id}', [UsersController::class, 'editForm'])->name('user-edit');
        Route::post('/edit', [UsersController::class, 'updateUser'])->name('user-update');

    });

    Route::group(['prefix' => 'retailer'], function () {
        Route::get('/create-new', [RetailerController::class, 'index'])->name('retailer-create-new');
        Route::post('/create-retailer', [RetailerController::class, 'createRetailer'])->name('createRetailer');
        Route::get('/retailers-list', [RetailerController::class, 'retailers'])->name('retailer-retailers-list');
        Route::get('/retailer-list-get', [RetailerController::class, 'retailerList'])->name('retailerList');
        Route::post('/retailer-status-change', [RetailerController::class, 'retailerStatusChange'])->name('retailerStatusChange');
        Route::post('/retailer-delete', [RetailerController::class, 'retailerDelete'])->name('retailerDelete');
        Route::get('/edit/{id}', [RetailerController::class, 'editForm'])->name('retailer-edit');
        Route::post('/edit', [RetailerController::class, 'updateRetailer'])->name('retailer-update');
    });

    Route::group(['prefix' => 'lead'], function () {
        Route::get('/create-new', [LeadController::class, 'index'])->name('lead-create-new');
        Route::post('/create-lead', [LeadController::class, 'createlead'])->name('createLead');
        Route::get('/leads-list', [LeadController::class, 'leads'])->name('lead-leads-list');
        Route::get('/lead-list-get', [LeadController::class, 'leadList'])->name('leadList');
        // Route::post('/lead-status-change', [LeadController::class, 'leadStatusChange'])->name('leadStatusChange');
        Route::post('/lead-delete', [LeadController::class, 'leadDelete'])->name('leadDelete');
        Route::get('/edit/{id}', [LeadController::class, 'editForm'])->name('lead-edit');
        // Route::post('/edit', [LeadController::class, 'updatelead'])->name('lead-update');
        Route::post('/assign-lead', [LeadController::class, 'assignLeads'])->name('lead-assign');
    });

    Route::get('/logout', function () {
        // Auth::logout();
        Auth::logoutCurrentDevice();
        return redirect()->route('login');
    })->name('logout');
});
