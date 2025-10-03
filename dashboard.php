<?php 
include "auth.php"; 
include "config/db.php"; // ← AJOUT IMPORTANT
include "templates/header.php"; 
?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-lg-2 col-md-3 bg-dark text-white vh-100 position-fixed">
            <div class="sidebar-sticky pt-4">
                <h4 class="text-center mb-4 border-bottom pb-3">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </h4>
                
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="clients.php" class="nav-link text-white d-flex align-items-center p-3 rounded">
                            <i class="fas fa-users me-3"></i>
                            Gérer les Clients
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="vehicules.php" class="nav-link text-white d-flex align-items-center p-3 rounded">
                            <i class="fas fa-car me-3"></i>
                            Gérer les Véhicules
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="ventes.php" class="nav-link text-white d-flex align-items-center p-3 rounded">
                            <i class="fas fa-shopping-cart me-3"></i>
                            Gérer les Ventes
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="locations.php" class="nav-link text-white d-flex align-items-center p-3 rounded">
                            <i class="fas fa-key me-3"></i>
                            Gérer les Locations
                        </a>
                    </li>
                </ul>
                
                <div class="mt-5 pt-4 border-top">
                    <a href="logout.php" class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-10 col-md-9 ms-auto">
            <div class="p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-primary">
                        <i class="fas fa-tachometer-alt me-2"></i>Tableau de Bord
                    </h1>
                    <div class="text-muted">
                        Bienvenue, <?php echo $_SESSION['email'] ?? 'Administrateur'; ?>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-5">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Clients
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php 
                                            try {
                                                $stmt = $pdo->query("SELECT COUNT(*) FROM clients");
                                                echo $stmt->fetchColumn();
                                            } catch (Exception $e) {
                                                echo "0";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Véhicules
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php 
                                            try {
                                                $stmt = $pdo->query("SELECT COUNT(*) FROM vehicules");
                                                echo $stmt->fetchColumn();
                                            } catch (Exception $e) {
                                                echo "0";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-car fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Ventes ce mois
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php 
                                            try {
                                                $stmt = $pdo->query("SELECT COUNT(*) FROM ventes WHERE MONTH(date_vente) = MONTH(CURRENT_DATE())");
                                                echo $stmt->fetchColumn();
                                            } catch (Exception $e) {
                                                echo "0";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Locations actives
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php 
                                            try {
                                                $stmt = $pdo->query("SELECT COUNT(*) FROM locations WHERE date_fin >= CURRENT_DATE()");
                                                echo $stmt->fetchColumn();
                                            } catch (Exception $e) {
                                                echo "0";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-key fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-bolt me-2 text-warning"></i>Actions Rapides
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <a href="clients.php?action=add" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center p-3">
                                            <i class="fas fa-user-plus fa-2x mb-2"></i>
                                            <span>Nouveau Client</span>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="vehicules.php?action=add" class="btn btn-outline-success w-100 d-flex flex-column align-items-center p-3">
                                            <i class="fas fa-car-side fa-2x mb-2"></i>
                                            <span>Ajouter Véhicule</span>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="ventes.php?action=add" class="btn btn-outline-info w-100 d-flex flex-column align-items-center p-3">
                                            <i class="fas fa-receipt fa-2x mb-2"></i>
                                            <span>Nouvelle Vente</span>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="locations.php?action=add" class="btn btn-outline-warning w-100 d-flex flex-column align-items-center p-3">
                                            <i class="fas fa-file-contract fa-2x mb-2"></i>
                                            <span>Nouvelle Location</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ajouter Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.sidebar-sticky {
    position: sticky;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: 0.5rem;
    overflow-x: hidden;
    overflow-y: auto;
}

.nav-link {
    transition: all 0.3s ease;
}

.nav-link:hover {
    background-color: rgba(255,255,255,0.1);
    transform: translateX(5px);
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
</style>

<?php include "templates/footer.php"; ?>