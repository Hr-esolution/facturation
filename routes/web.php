<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FactureParametreController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmetteurController;
use App\Http\Controllers\Admin\FactureTemplateController;
use App\Http\Controllers\Admin\FactureChampController;
use Illuminate\Support\Facades\Auth;

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

// Public route
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes();

// Home route after login - redirects to appropriate dashboard
Route::get('/home', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }
    return redirect()->route('login');
})->name('home');

// User dashboard route
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard')->middleware('auth');

// Routes pour les factures
Route::resource('factures', FactureController::class)->middleware('auth');
Route::get('factures/{facture}/pdf', [FactureController::class, 'generatePDF'])->name('factures.pdf')->middleware('auth');
Route::post('factures/{facture}/send-email', [FactureController::class, 'sendByEmail'])->name('factures.send-email')->middleware('auth');

// Routes pour les clients
Route::resource('clients', ClientController::class)->middleware('auth');

// Routes pour les émetteurs
Route::resource('emetteurs', EmetteurController::class)->middleware('auth');

// Routes pour les produits
Route::resource('products', ProductController::class)->middleware('auth');

// Routes pour les paramètres de facturation
Route::resource('facture-parametres', FactureParametreController::class)->middleware('auth');

// Routes pour les paramètres généraux
Route::prefix('settings')->name('settings.')->middleware('auth')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::post('signature', [SettingController::class, 'updateSignature'])->name('update.signature');
    Route::post('email-partage', [SettingController::class, 'updateEmailPartage'])->name('update.email-partage');
    Route::post('logo', [SettingController::class, 'updateLogo'])->name('update.logo');
});

// Routes admin pour les templates et champs
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('facture-templates', FactureTemplateController::class);
    Route::put('facture-templates/{template}/toggle-status', [FactureTemplateController::class, 'toggleStatus'])->name('facture-templates.toggle-status');
    Route::put('facture-templates/{template}/set-default', [FactureTemplateController::class, 'setAsDefault'])->name('facture-templates.set-default');
    
    Route::resource('facture-champs', FactureChampController::class);
    Route::get('facture-champs/pays/{pays}', [FactureChampController::class, 'getByPays'])->name('facture-champs.pays');
    Route::get('facture-champs/pays/{pays}/required', [FactureChampController::class, 'getRequiredByPays'])->name('facture-champs.required');
    Route::put('facture-champs/update-order', [FactureChampController::class, 'updateOrder'])->name('facture-champs.update-order');
});
