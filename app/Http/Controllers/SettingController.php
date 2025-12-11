<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signature = Setting::getByType('signature');
        $emailPartage = Setting::getByType('email_partage');
        $logo = Setting::getByType('logo');
        
        return view('settings.index', compact('signature', 'emailPartage', 'logo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        // Authorization: user can only edit their own settings
        if ($setting->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        // Authorization: user can only update their own settings
        if ($setting->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        $request->validate([
            'valeur' => 'required',
        ]);

        $setting->update($request->all());

        return redirect()->route('settings.index')->with('success', 'Paramètre mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }

    /**
     * Update signature setting
     */
    public function updateSignature(Request $request)
    {
        $request->validate([
            'signature' => 'required|string',
        ]);

        Setting::setByType('signature', ['signature' => $request->signature]);

        return redirect()->route('settings.index')->with('success', 'Signature mise à jour avec succès.');
    }

    /**
     * Update email partage setting
     */
    public function updateEmailPartage(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Setting::setByType('email_partage', ['email' => $request->email]);

        return redirect()->route('settings.index')->with('success', 'Email de partage mis à jour avec succès.');
    }

    /**
     * Update logo setting
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            Setting::setByType('logo', ['logo_path' => $logoPath]);
        }

        return redirect()->route('settings.index')->with('success', 'Logo mis à jour avec succès.');
    }
}