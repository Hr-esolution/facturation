<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
        }
        
        .sidebar .nav-link span.collapse-text {
            display: inline;
        }
        
        .sidebar.collapsed .nav-link span.collapse-text {
            display: none;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }
        
        .topbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 30px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .bg-primary-light { background-color: rgba(102, 126, 234, 0.1); color: #667eea; }
        .bg-success-light { background-color: rgba(40, 167, 69, 0.1); color: #28a745; }
        .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .bg-info-light { background-color: rgba(23, 162, 184, 0.1); color: #17a2b8; }
        
        .recent-item {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s ease;
        }
        
        .recent-item:last-child {
            border-bottom: none;
        }
        
        .recent-item:hover {
            background-color: #f8f9fa;
        }
        
        .action-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            color: white;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-4">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-file-invoice-dollar fs-2 me-3"></i>
                <span class="fs-4 fw-bold collapse-text">{{ config('app.name', 'Laravel') }}</span>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span class="collapse-text">Tableau de bord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('factures.index') }}">
                        <i class="fas fa-file-invoice"></i>
                        <span class="collapse-text">Factures</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clients.index') }}">
                        <i class="fas fa-users"></i>
                        <span class="collapse-text">Clients</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">
                        <i class="fas fa-box"></i>
                        <span class="collapse-text">Produits</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('emetteurs.index') }}">
                        <i class="fas fa-building"></i>
                        <span class="collapse-text">Émetteurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('facture-parametres.index') }}">
                        <i class="fas fa-cog"></i>
                        <span class="collapse-text">Paramètres</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.index') }}">
                        <i class="fas fa-sliders-h"></i>
                        <span class="collapse-text">Configuration</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary me-3" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                </div>
                
                <div class="dropdown">
                    <a class="dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fs-4 me-2"></i>
                        <span>{{ Auth::user()->name ?? 'Utilisateur' }}</span>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container-fluid p-4">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>