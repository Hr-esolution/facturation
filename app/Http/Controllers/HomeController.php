<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin dashboard
            $totalUsers = \App\Models\User::count();
            $totalFactures = \App\Models\Facture::count();
            $totalClients = \App\Models\Client::count();
            $totalMontant = \App\Models\Facture::sum('montant_total');

            return view('admin.dashboard', compact('totalUsers', 'totalFactures', 'totalClients', 'totalMontant'));
        } else {
            // User dashboard
            $totalFactures = \App\Models\Facture::where('user_id', $user->id)->count();
            $totalClients = \App\Models\Client::where('user_id', $user->id)->count();
            $totalEmetteurs = \App\Models\Emetteur::where('user_id', $user->id)->count();
            $totalMontant = \App\Models\Facture::where('user_id', $user->id)->sum('montant_total');

            return view('user.dashboard', compact('totalFactures', 'totalClients', 'totalEmetteurs', 'totalMontant'));
        }
    }
}
