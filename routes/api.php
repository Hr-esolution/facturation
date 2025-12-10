<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\MobileFactureController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API versionnée pour l'application mobile
Route::prefix('v1')->name('api.v1.')->group(function () {
    // Routes pour les factures mobile
    Route::apiResource('factures', MobileFactureController::class);
    Route::get('factures/{id}/pdf', [MobileFactureController::class, 'generatePDF'])->name('factures.pdf');
    Route::get('factures/search', [MobileFactureController::class, 'search'])->name('factures.search');
});

// Routes API publiques pour la vérification des factures
Route::get('factures/{id}/verify', function ($id) {
    $facture = \App\Models\Facture::find($id);
    
    if (!$facture) {
        return response()->json(['error' => 'Facture non trouvée'], 404);
    }
    
    return response()->json([
        'success' => true,
        'data' => [
            'numero_facture' => $facture->numero_facture,
            'date_emission' => $facture->date_emission,
            'total_ttc' => $facture->total_ttc,
            'statut' => $facture->statut,
            'valide' => true // Dans une implémentation réelle, on vérifierait la signature
        ]
    ]);
})->name('factures.verify');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
