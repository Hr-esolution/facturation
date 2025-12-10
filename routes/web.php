<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FactureParametreController;
use App\Http\Controllers\Admin\FactureTemplateController;
use App\Http\Controllers\Admin\FactureChampController;

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
    return view('welcome');
});

// Routes pour les factures
Route::resource('factures', FactureController::class);
Route::get('factures/{facture}/pdf', [FactureController::class, 'generatePDF'])->name('factures.pdf');
Route::post('factures/{facture}/send-email', [FactureController::class, 'sendByEmail'])->name('factures.send-email');

// Routes pour les paramètres de facturation
Route::resource('facture-parametres', FactureParametreController::class);
Route::get('facture-parametres/pays/{pays}', [FactureParametreController::class, 'getByPays'])->name('facture-parametres.pays');
Route::get('facture-parametres/cle/{cle}', [FactureParametreController::class, 'getByCle'])->name('facture-parametres.cle');

// Routes admin pour les templates et champs
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('facture-templates', FactureTemplateController::class);
    Route::put('facture-templates/{template}/toggle-status', [FactureTemplateController::class, 'toggleStatus'])->name('facture-templates.toggle-status');
    Route::put('facture-templates/{template}/set-default', [FactureTemplateController::class, 'setAsDefault'])->name('facture-templates.set-default');
    
    Route::resource('facture-champs', FactureChampController::class);
    Route::get('facture-champs/pays/{pays}', [FactureChampController::class, 'getByPays'])->name('facture-champs.pays');
    Route::get('facture-champs/pays/{pays}/required', [FactureChampController::class, 'getRequiredByPays'])->name('facture-champs.required');
    Route::put('facture-champs/update-order', [FactureChampController::class, 'updateOrder'])->name('facture-champs.update-order');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
