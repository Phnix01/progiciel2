<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almou Auto - Administration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(45deg, #ff6b35, #f7931e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            margin: 0 0.2rem;
        }
        
        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }
        
        .user-dropdown {
            border-left: 1px solid #495057;
        }
        
        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(25%, -25%);
        }
        
        .search-box {
            min-width: 300px;
        }
        
        @media (max-width: 768px) {
            .search-box {
                min-width: 200px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
                <i class="fas fa-car me-2"></i>
                Almou Auto
                <small class="badge bg-warning text-dark ms-2 fs-6">Admin</small>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Navigation Menu -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cogs me-2"></i>
                            Gestion
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="clients.php"><i class="fas fa-users me-2"></i>Clients</a></li>
                            <li><a class="dropdown-item" href="vehicules.php"><i class="fas fa-car me-2"></i>Véhicules</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="ventes.php"><i class="fas fa-shopping-cart me-2"></i>Ventes</a></li>
                            <li><a class="dropdown-item" href="locations.php"><i class="fas fa-key me-2"></i>Locations</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="reports.php">
                            <i class="fas fa-chart-bar me-2"></i>
                            Rapports
                        </a>
                    </li>
                </ul>

                <!-- Right Section -->
                <div class="navbar-nav align-items-center">
                    <!-- Search Bar -->
                    <div class="nav-item me-3">
                        <div class="input-group search-box">
                            <input type="text" class="form-control form-control-sm bg-secondary border-dark text-white" placeholder="Rechercher...">
                            <button class="btn btn-warning btn-sm" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="nav-item dropdown me-2">
                        <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fa-lg"></i>
                            <span class="notification-badge badge bg-danger rounded-pill">3</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-car text-warning me-2"></i>Nouveau véhicule ajouté</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-users text-info me-2"></i>5 nouveaux clients</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Location expirant demain</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="notifications.php">Voir toutes</a></li>
                        </ul>
                    </div>

                    <!-- User Menu -->
                    <div class="nav-item dropdown user-dropdown ps-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="fas fa-user text-dark"></i>
                            </div>
                            <span class="d-none d-md-inline">
                                <?php echo $_SESSION['email'] ?? 'Admin'; ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            <li><h6 class="dropdown-header">Connecté en tant que</h6></li>
                            <li><div class="dropdown-item-text text-warning"><?php echo $_SESSION['email'] ?? 'Administrateur'; ?></div></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user-cog me-2"></i>Mon profil</a></li>
                            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS for interactive elements -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.remove();
                }, 5000);
            });
            
            // Search functionality
            const searchInput = document.querySelector('input[placeholder="Rechercher..."]');
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch(this.value);
                }
            });
        });
        
        function performSearch(query) {
            if (query.trim() !== '') {
                window.location.href = `search.php?q=${encodeURIComponent(query)}`;
            }
        }
    </script>