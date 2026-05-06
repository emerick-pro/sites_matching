<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRE DES FOSA - SIDAInfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;500;600&display=swap');
        
        :root {
            --primary-navy: #1E3A5F;
            --primary-navy-light: #2C4A6E;
            --primary-gold: #C7A02E;
            --primary-gold-light: #D4AF37;
            --primary-gold-dim: #F5F0E0;
            --accent-teal: #2D6A4F;
            --accent-teal-light: #E8F5E9;
            --gray-50: #FAFAFA;
            --gray-100: #F5F5F5;
            --gray-200: #EEEEEE;
            --gray-300: #E0E0E0;
            --gray-600: #757575;
            --gray-700: #616161;
            --gray-800: #424242;
            --gray-900: #212121;
            --success: #2E7D32;
            --error: #C62828;
            --warning: #F57C00;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            min-height: 100vh;
        }
        
        /* Navigation principale */
        .main-nav {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-navy-light) 100%);
            box-shadow: 0 8px 20px rgba(30, 58, 95, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border-bottom: 2px solid var(--primary-gold);
        }
        
        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.875rem 0;
        }
        
        .nav-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }
        
        .menu-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            font-size: 1.125rem;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
            border-color: var(--primary-gold);
        }
        
        .brand-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .burundi-emblem {
            width: 52px;
            height: 52px;
            object-fit: contain;
            background: white;
            padding: 6px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        
        .burundi-emblem:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }
        
        .brand-separator {
            width: 2px;
            height: 44px;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.4), transparent);
        }
        
        .brand-text h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
            margin: 0;
            letter-spacing: -0.3px;
            font-family: 'Playfair Display', serif;
        }
        
        .brand-text h1 span {
            color: var(--primary-gold);
            font-weight: 700;
        }
        
        .brand-text p {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
            font-weight: 400;
            letter-spacing: 0.5px;
        }
        
        .brand-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 215, 0, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: var(--primary-gold);
        }
        
        /* Boutons d'authentification */
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .btn-login {
            background: transparent;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            backdrop-filter: blur(10px);
        }
        
        .btn-login:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-gold);
            transform: translateY(-2px);
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-light) 100%);
            border: none;
            color: var(--primary-navy);
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            box-shadow: 0 4px 12px rgba(199, 160, 46, 0.3);
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(199, 160, 46, 0.4);
        }
        
        .btn-logout {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            backdrop-filter: blur(10px);
        }
        
        .btn-logout:hover {
            background: rgba(198, 40, 40, 0.8);
            border-color: var(--error);
            transform: translateY(-2px);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.35rem 1rem 0.35rem 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-light) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-avatar i {
            color: var(--primary-navy);
            font-size: 1rem;
        }
        
        .user-name {
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
        }
        
        /* Mobile Menu Button */
        .mobile-auth-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            color: white;
        }
        
        .mobile-auth-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        
        /* Content Area */
        main {
            min-height: calc(100vh - 160px);
            padding: 1.5rem 0;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-navy-light) 100%);
            color: white;
            padding: 2rem 1.5rem;
            margin-top: 2rem;
            text-align: center;
            position: relative;
            border-top: 2px solid var(--primary-gold);
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-gold), transparent);
        }
        
        footer p {
            margin: 0;
            font-size: 0.875rem;
            opacity: 0.9;
        }
        
        footer p:first-child {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        /* Container personnalisé */
        .container-custom {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        /* Cards élégants */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(199, 160, 46, 0.1);
        }
        
        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        
        /* Badges élégants */
        .badge-success {
            background: linear-gradient(135deg, var(--success) 0%, #43A047 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #FF9800 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-danger {
            background: linear-gradient(135deg, var(--error) 0%, #EF5350 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        /* Boutons d'action */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-navy-light) 100%);
            border: none;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
        }
        
        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--primary-navy);
            color: var(--primary-navy);
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline:hover {
            background: var(--primary-navy);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Liens */
        .offre-link {
            font-weight: 500;
            padding: 0.35rem 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-navy);
            background: rgba(199, 160, 46, 0.1);
            font-size: 0.875rem;
        }
        
        .offre-link:hover {
            background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-light) 100%);
            color: var(--primary-navy);
            transform: translateX(5px);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 1rem;
            }
            
            .container-custom {
                padding: 0 1rem;
            }
            
            .auth-buttons {
                display: none;
            }
            
            .mobile-auth-btn {
                display: flex;
            }
            
            .brand-text h1 {
                font-size: 0.9rem;
            }
            
            .brand-text p {
                font-size: 0.6rem;
            }
            
            .burundi-emblem {
                width: 40px;
                height: 40px;
            }
            
            .brand-separator {
                height: 36px;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .brand-text h1 {
                font-size: 1rem;
            }
        }
        
        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--gray-200);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-light) 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-gold);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="main-nav">
        <div class="nav-container">
            <div class="nav-content">
                <!-- Logo et bouton menu -->
                <div class="nav-left">
                    <button id="menuToggle" class="menu-toggle" aria-label="Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="brand-container">
                        <div class="brand-separator"></div>
                        <div class="brand-text">
                            <h1>
                                SIDAInfo <span>Registre des FOSA</span>
                            </h1>
                            <p>Table de correspondance SIDAInfo ↔ DHIS2</p>
                        </div>
                    </div>
                </div>
                
                <!-- Boutons d'authentification Desktop -->
                <div class="auth-buttons">
                    @guest
                        <button onclick="openLoginModal()" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i> Connexion
                        </button>
                       
                    @endguest
                    
                    @auth
                        <div class="user-info">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="user-name">
                                {{-- Auth::user()->nom_prenom ?? Auth::user()->name ?? 'Utilisateur' --}}
                            </span>
                        </div>
                        <button class="btn-logout" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </button>
                    @endauth
                </div>
                
                <!-- Bouton mobile -->
                <button class="mobile-auth-btn" onclick="openLoginModal()">
                    <i class="fas fa-user"></i>
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Contenu principal -->
    <main>
        <div class="container-custom fade-in">
            @yield('content_here')
        </div>
    </main>
    
    <!-- Footer -->
    <footer>
        <p><i class="fas fa-heart" style="color: var(--primary-gold);"></i> Direction de la Gestion de l'Informatique Sanitaire</p>
        <p>Ministère de la Santé Publique</p>
        <p style="font-size: 0.7rem; margin-top: 1rem; opacity: 0.6;">&copy; {{ date('Y') }} Tous droits réservés</p>
    </footer>
    
    <script>
        // Menu toggle (à implémenter selon vos besoins)
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            console.log('Menu toggled');
        });
        
        function openLoginModal() {
            console.log('Open login modal');
        }
        
        function openRegisterModal() {
            console.log('Open register modal');
        }
        
        function confirmLogout() {
            if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
               
            }
        }
        
        // Animation au scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.main-nav');
            if (window.scrollY > 50) {
                nav.style.backdropFilter = 'blur(10px)';
                nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.1)';
            } else {
                nav.style.backdropFilter = 'blur(10px)';
                nav.style.boxShadow = '0 8px 20px rgba(30, 58, 95, 0.15)';
            }
        });
    </script>
</body>
</html>