<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRE DES FOSA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
	<meta name="csrf-token" value="{{ csrf_token() }}"/>

    
    <style>
        :root {
            --burundi-red: #CE1126;
            --burundi-green: #1EB53A;
            --burundi-white: #FFFFFF;
            --burundi-dark: #1a1a1a;
            --burundi-light-green: #E8F5E9;
            --burundi-light-red: #FFEBEE;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        /* Navigation principale */
        .main-nav {
            background: linear-gradient(135deg, var(--burundi-red) 0%, #A81020 100%);
            box-shadow: 0 4px 12px rgba(206, 17, 38, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .menu-toggle {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            font-size: 1.25rem;
            color: var(--burundi-white);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.05);
        }
        
        .menu-toggle:active {
            transform: scale(0.95);
        }
        
        .brand-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .burundi-emblem {
            width: 56px;
            height: 56px;
            object-fit: contain;
            background: white;
            padding: 4px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        
        .burundi-emblem:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }
        
        .brand-separator {
            width: 2px;
            height: 48px;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.5), transparent);
            margin: 0 0.25rem;
        }
        
        .brand-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }
        
        .brand-text h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--burundi-white);
            margin: 0;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .brand-text p {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            font-weight: 500;
        }
        
        .burundi-flag-accent {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--burundi-green);
            margin-left: 4px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.7;
                transform: scale(1.1);
            }
        }
        
        /* Boutons d'authentification */
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .btn-login {
            background: transparent;
            border: 2px solid var(--burundi-white);
            color: var(--burundi-white);
            padding: 0.625rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .btn-login:hover {
            background: var(--burundi-white);
            color: var(--burundi-red);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
        }
        
        .btn-register {
            background: var(--burundi-green);
            border: 2px solid var(--burundi-green);
            color: var(--burundi-white);
            padding: 0.625rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            box-shadow: 0 2px 8px rgba(30, 181, 58, 0.3);
        }
        
        .btn-register:hover {
            background: #19A332;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 181, 58, 0.4);
        }
        
        .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: var(--burundi-white);
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }
        
        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }
        
        .btn-logout i {
            font-size: 1rem;
        }
        
        /* Mobile Menu Button */
        .mobile-auth-btn {
            background: var(--burundi-white);
            color: var(--burundi-red);
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        
        /* Content Area */
        main {
            min-height: calc(100vh - 200px);
        }
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, #2C3E50 0%, #34495E 100%);
            color: var(--burundi-white);
            padding: 2rem 1rem;
            margin-top: 3rem;
            text-align: center;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-buttons {
                display: none;
            }
            
            .mobile-auth-btn {
                display: flex;
            }
            
            .brand-text h1 {
                font-size: 1.25rem;
            }
            
            .brand-text p {
                font-size: 0.7rem;
            }
            
            .burundi-emblem {
                width: 48px;
                height: 48px;
            }
            
            .brand-separator {
                height: 40px;
            }
            
            .nav-content {
                padding: 0.75rem 0;
            }
        }
        
        @media (max-width: 480px) {
            .brand-text h1 {
                font-size: 1rem;
            }
            
            .brand-text p {
                display: none;
            }
            
            .burundi-emblem {
                width: 40px;
                height: 40px;
            }
            
            .brand-separator {
                height: 35px;
            }
            
            .menu-toggle {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }
        }
        
        /* Hover effects */
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
		/* Pour link to offres --*/
		
		 .offre-link {
            font-family: 'Poppins', 'Segoe UI', 'Montserrat', sans-serif;
            font-weight: 600;
            letter-spacing: 0.3px;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
			color: RGB(204,255,255);
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
                                Système d'Information Saniataire du Burundi
                                <span class="burundi-flag-accent"></span>
                            </h1>
                            <p>Tabeau de matching Formations sanitaires de DHIS2</p>
                        </div>
                    </div>
                </div>
				
				
				
				<!--  -->
				
                
                <!-- Boutons d'authentification Desktop -->
              
				<div class="auth-buttons">
					@guest
					<!--
					<button onclick="openLoginModal()" class="btn-login">
						Connexion
					</button>
					<button onclick="openRegisterModal()" class="btn-register">
						S'inscrire
					</button>
					-->
					@endguest
					
					@auth
					<div class="flex items-center gap-3">
						<div class="flex items-center gap-2 px-3 py-1.5 bg-white/10 rounded-full">
							<div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
								<i class="fas fa-user text-white text-sm"></i>
							</div>
							<span class="text-white text-sm font-medium hidden sm:inline">
								{{ Auth::user()->nom_prenom ?? Auth::user()->name ?? 'Utilisateur' }}
							</span>
						</div>
						<button class="btn-logout" onclick="confirmLogout()">
							<i class="fas fa-sign-out-alt"></i>
							<span class="hidden sm:inline">Déconnexion</span>
						</button>
					</div>
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
        @yield('content_here')
    </main>
    
    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} DGISA Burundi - Tous droits réservés</p>
        <p style="font-size: 0.875rem; margin-top: 0.5rem; opacity: 0.9;">
            Ministère de la Santé Publique
        </p>
    </footer>
    
    
</body>

</html>