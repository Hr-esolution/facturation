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
        $totalFactures = \App\Models\Facture::count();
        $totalClients = \App\Models\Client::count();
        $totalEmetteurs = \App\Models\Emetteur::count();
        $totalMontant = \App\Models\Facture::sum('total_ttc');

        return view('dashboard', compact('totalFactures', 'totalClients', 'totalEmetteurs', 'totalMontant'));
    }
}
