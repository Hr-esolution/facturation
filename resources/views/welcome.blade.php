<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            :root {
                /* Pantone 2025 Colors */
                --pantone-2025-pepper-coral: #FF6B6B;
                --pantone-2025-ashen-aqua: #88BDBC;
                --pantone-2025-sweet-creme: #F9E7E1;
                --pantone-2025-slate-green: #6B8E8A;
                --pantone-2025-bright-amber: #F9C74F;
                --pantone-2025-deep-forest: #277DA1;
                --pantone-2025-soft-mint: #90BE6D;
            }
            
            body {
                margin: 0;
                padding: 0;
                min-height: 100vh;
                background: linear-gradient(135deg, 
                    var(--pantone-2025-sweet-creme) 0%, 
                    var(--pantone-2025-ashen-aqua) 30%, 
                    var(--pantone-2025-slate-green) 100%);
                font-family: 'Figtree', sans-serif;
                overflow-x: hidden;
            }
            
            .glass-container {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.18);
                border-radius: 20px;
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            }
            
            .glass-card {
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.18);
                border-radius: 16px;
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.25);
            }
            
            .btn-glass {
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.18);
                border-radius: 12px;
                padding: 12px 24px;
                color: #333;
                text-decoration: none;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }
            
            .btn-glass:hover {
                background: rgba(255, 255, 255, 0.35);
                transform: translateY(-2px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            }
            
            .btn-primary {
                background: linear-gradient(135deg, var(--pantone-2025-pepper-coral), var(--pantone-2025-bright-amber));
                color: white !important;
                border: none;
            }
            
            .btn-secondary {
                background: linear-gradient(135deg, var(--pantone-2025-ashen-aqua), var(--pantone-2025-slate-green));
                color: white !important;
                border: none;
            }
            
            .btn-success {
                background: linear-gradient(135deg, var(--pantone-2025-soft-mint), var(--pantone-2025-deep-forest));
                color: white !important;
                border: none;
            }
            
            .feature-card {
                transition: all 0.3s ease;
                border-radius: 16px;
                overflow: hidden;
            }
            
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            }
            
            .text-gradient {
                background: linear-gradient(135deg, var(--pantone-2025-pepper-coral), var(--pantone-2025-bright-amber));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            @if (Route::has('login'))
                <div class="absolute top-4 right-4 z-10">
                    @auth
                        <a href="{{ url('/home') }}" class="btn-glass">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-glass">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-glass ml-2">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-6xl mx-auto w-full">
                <!-- Welcome Section -->
                <div class="text-center mb-16">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 text-white">
                        <span class="text-gradient">Bienvenue sur</span> {{ config('app.name', 'Laravel') }}
                    </h1>
                    <p class="text-xl text-white/90 max-w-2xl mx-auto">
                        Votre plateforme de gestion de facturation intelligente avec conformité internationale
                    </p>
                </div>

                <!-- Navigation Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    <div class="glass-card p-8 text-center feature-card">
                        <div class="w-16 h-16 bg-gradient-to-r from-[var(--pantone-2025-pepper-coral)] to-[var(--pantone-2025-bright-amber)] rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Gestion des Factures</h3>
                        <p class="text-white/80 mb-6">Créez, gérez et suivez toutes vos factures avec facilité</p>
                        <a href="{{ route('factures.index') }}" class="btn-glass btn-primary w-full">Accéder aux factures</a>
                    </div>

                    <div class="glass-card p-8 text-center feature-card">
                        <div class="w-16 h-16 bg-gradient-to-r from-[var(--pantone-2025-ashen-aqua)] to-[var(--pantone-2025-slate-green)] rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Clients</h3>
                        <p class="text-white/80 mb-6">Gérez vos clients et leurs informations de facturation</p>
                        <a href="#" class="btn-glass btn-secondary w-full">Accéder aux clients</a>
                    </div>

                    <div class="glass-card p-8 text-center feature-card">
                        <div class="w-16 h-16 bg-gradient-to-r from-[var(--pantone-2025-soft-mint)] to-[var(--pantone-2025-deep-forest)] rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Émetteurs</h3>
                        <p class="text-white/80 mb-6">Configurez les émetteurs et leurs paramètres</p>
                        <a href="#" class="btn-glass btn-success w-full">Accéder aux émetteurs</a>
                    </div>

                    <div class="glass-card p-8 text-center feature-card">
                        <div class="w-16 h-16 bg-gradient-to-r from-[var(--pantone-2025-bright-amber)] to-[var(--pantone-2025-pepper-coral)] rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Paramètres</h3>
                        <p class="text-white/80 mb-6">Configurez les paramètres de facturation</p>
                        <a href="{{ route('facture-parametres.index') }}" class="btn-glass btn-primary w-full">Paramètres de facturation</a>
                    </div>

                    <div class="glass-card p-8 text-center feature-card">
                        <div class="w-16 h-16 bg-gradient-to-r from-[var(--pantone-2025-slate-green)] to-[var(--pantone-2025-ashen-aqua)] rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Templates</h3>
                        <p class="text-white/80 mb-6">Gérez les modèles de factures</p>
                        <a href="{{ route('admin.facture-templates.index') }}" class="btn-glass btn-secondary w-full">Templates de factures</a>
                    </div>

                    <div class="glass-card p-8 text-center feature-card">
                        <div class="w-16 h-16 bg-gradient-to-r from-[var(--pantone-2025-deep-forest)] to-[var(--pantone-2025-soft-mint)] rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Rapports</h3>
                        <p class="text-white/80 mb-6">Accédez aux rapports et analyses</p>
                        <a href="#" class="btn-glass btn-success w-full">Voir les rapports</a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="glass-card p-8 mb-16">
                    <h2 class="text-2xl font-semibold text-white mb-6 text-center">Vue d'ensemble</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">150+</div>
                            <div class="text-white/70">Factures créées</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">85%</div>
                            <div class="text-white/70">Taux de conformité</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">24</div>
                            <div class="text-white/70">Clients actifs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">12</div>
                            <div class="text-white/70">Émetteurs configurés</div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center text-white/70">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Tous droits réservés.</p>
                    <p class="mt-2">Conçu avec les couleurs Pantone 2025 pour une expérience moderne</p>
                </div>
            </div>
        </div>
    </body>
</html>