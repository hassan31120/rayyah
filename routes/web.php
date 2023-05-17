<?php

use App\Http\Controllers\Admin\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\Admin\ComplainController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\InvoiceAttachmentController;

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

Route::get('/', function () {
    return view('signin');
})->name('signin');

Route::get('table', function () {
    return view('table-basic');
});
Route::get('/home', [AdminController::class, 'home'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language');


Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LangController@switchLang']);

Route::middleware('auth')->group(function () {

    Route::controller(ServiceController::class)->group(function () {
        Route::get('services', 'index')->name('services');
        Route::get('services/create', 'create')->name('services.create');
        Route::post('services/store', 'store')->name('services.store');
        Route::get('services/edit/{id}', 'edit')->name('services.edit');
        Route::post('services/update/{id}', 'update')->name('services.update');
        Route::delete('services/delete/{id}', 'destroy')->name('services.delete');
    });

    Route::controller(BannerController::class)->group(function() {
        Route::get('banners', 'index')->name('banners');
        Route::get('banner/create', 'create')->name('banner.create');
        Route::post('banner/create', 'store')->name('banner.store');
        Route::delete('banner/delete/{id}', 'destroy')->name('banner.delete');
    });

    Route::controller(TransactionController::class)->group(function () {
        Route::get('transactions', 'index')->name('users.index');
    });

    Route::prefix('users')->group(function () {
        Route::controller(ClientController::class)->group(function () {
            Route::get('users', 'index')->name('users');
            Route::get('user/create', 'create')->name('user.create');
            Route::post('user/store', 'store')->name('user.store');
            Route::get('user/edit/{id}', 'edit')->name('user.edit');
            Route::post('user/update/{id}', 'update')->name('user.update');
            Route::delete('user/delete/{id}', 'destroy')->name('user.destroy');
        });

        Route::controller(DeliveryController::class)->group(function () {
            Route::get('deliverys', 'index')->name('deliverys');
            Route::get('delivery/create', 'create')->name('delivery.create');
            Route::post('delivery/store', 'store')->name('delivery.store');
            Route::get('delivery/edit/{id}', 'edit')->name('delivery.edit');
            Route::post('delivery/update/{id}', 'update')->name('delivery.update');
            Route::delete('delivery/delete/{id}', 'destroy')->name('delivery.destroy');
        });
    });

    Route::controller(ContactController::class)->group(function () {
        Route::get('settings/contacts', 'index')->name('contacts');
        Route::delete('settings/contact/delete/{id}', 'destroy')->name('contact.destroy');
    });

    Route::controller(ComplainController::class)->group(function () {
        Route::get('settings/complains', 'index')->name('complains');
        Route::delete('settings/complain/delete/{id}', 'destroy')->name('complain.destroy');
    });

    // Route::get('/home', 'HomeController@index')->name('home');


    // Route::get('MarkAsRead_all','InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');

    // Route::get('unreadNotifications_count', 'InvoicesController@unreadNotifications_count')->name('unreadNotifications_count');

    // Route::get('unreadNotifications', 'InvoicesController@unreadNotifications')->name('unreadNotifications');

    Route::get('/{page}', [AdminController::class, 'index']);
    Route::get('/{page}/edit', [AdminController::class, 'edit'])->name('profile.edit');
    Route::post('/{page}/update/{id}', [AdminController::class, 'update']);
});
require __DIR__ . '/auth.php';
