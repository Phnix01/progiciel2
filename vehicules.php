<?php
// vehicules.php
// Gère : ajout / édition / suppression / listing des véhicules
// - Include auth, db, header/footer (préexistants)
// - Nom de la table SQL attendu : `vehicules` (avec clé primaire id_vehicule)

include "auth.php";
include "config/db.php";
include "templates/header.php";

$error = null;
$success = null;

/* -------------------
   AJOUT D'UN VÉHICULE
   ------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vehicle'])) {
    try {
        $vin = !empty($_POST['vin']) ? trim($_POST['vin']) : null;
        $immatriculation = trim($_POST['immatriculation']);
        $type = !empty($_POST['type']) ? trim($_POST['type']) : null;
        $marque = !empty($_POST['marque']) ? trim($_POST['marque']) : null;
        $modele = !empty($_POST['modele']) ? trim($_POST['modele']) : null;
        $couleur = !empty($_POST['couleur']) ? trim($_POST['couleur']) : null;
        $puissance = !empty($_POST['puissance']) ? (int)$_POST['puissance'] : null;
        $nombre_places = !empty($_POST['nombre_places']) ? (int)$_POST['nombre_places'] : null;
        $nombre_portieres = !empty($_POST['nombre_portieres']) ? (int)$_POST['nombre_portieres'] : null;
        $date_mise_circulation = !empty($_POST['date_mise_circulation']) ? $_POST['date_mise_circulation'] : null;
        $carburant = !empty($_POST['carburant']) ? trim($_POST['carburant']) : null;
        $kilometrage = !empty($_POST['kilometrage']) ? (int)$_POST['kilometrage'] : null;
        $statut = !empty($_POST['statut']) ? $_POST['statut'] : 'disponible';
        $id_parc = !empty($_POST['id_parc']) ? (int)$_POST['id_parc'] : null;

        if (empty($immatriculation) || empty($marque)) {
            throw new Exception("Les champs immatriculation et marque sont obligatoires.");
        }

        $sql = "INSERT INTO vehicules 
            (vin, immatriculation, type, marque, modele, couleur, puissance, nombre_places, nombre_portieres, date_mise_circulation, carburant, kilometrage, statut, id_parc)
            VALUES (:vin, :immatriculation, :type, :marque, :modele, :couleur, :puissance, :nombre_places, :nombre_portieres, :date_mise_circulation, :carburant, :kilometrage, :statut, :id_parc)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':vin' => $vin,
            ':immatriculation' => $immatriculation,
            ':type' => $type,
            ':marque' => $marque,
            ':modele' => $modele,
            ':couleur' => $couleur,
            ':puissance' => $puissance,
            ':nombre_places' => $nombre_places,
            ':nombre_portieres' => $nombre_portieres,
            ':date_mise_circulation' => $date_mise_circulation,
            ':carburant' => $carburant,
            ':kilometrage' => $kilometrage,
            ':statut' => $statut,
            ':id_parc' => $id_parc
        ]);
        $success = "Véhicule ajouté avec succès.";
        header("Location: vehicules.php");
        exit;
    } catch (PDOException $e) {
        // gestion d'erreur SQL (ex : doublon immatriculation/vin)
        $error = "Erreur base de données : " . $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

/* -------------------
   MISE À JOUR D'UN VÉHICULE
   ------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_vehicle'])) {
    try {
        $id = (int)$_POST['id_vehicule'];
        $vin = !empty($_POST['vin']) ? trim($_POST['vin']) : null;
        $immatriculation = trim($_POST['immatriculation']);
        $type = !empty($_POST['type']) ? trim($_POST['type']) : null;
        $marque = !empty($_POST['marque']) ? trim($_POST['marque']) : null;
        $modele = !empty($_POST['modele']) ? trim($_POST['modele']) : null;
        $couleur = !empty($_POST['couleur']) ? trim($_POST['couleur']) : null;
        $puissance = !empty($_POST['puissance']) ? (int)$_POST['puissance'] : null;
        $nombre_places = !empty($_POST['nombre_places']) ? (int)$_POST['nombre_places'] : null;
        $nombre_portieres = !empty($_POST['nombre_portieres']) ? (int)$_POST['nombre_portieres'] : null;
        $date_mise_circulation = !empty($_POST['date_mise_circulation']) ? $_POST['date_mise_circulation'] : null;
        $carburant = !empty($_POST['carburant']) ? trim($_POST['carburant']) : null;
        $kilometrage = !empty($_POST['kilometrage']) ? (int)$_POST['kilometrage'] : null;
        $statut = !empty($_POST['statut']) ? $_POST['statut'] : 'disponible';
        $id_parc = !empty($_POST['id_parc']) ? (int)$_POST['id_parc'] : null;

        if (empty($immatriculation) || empty($marque)) {
            throw new Exception("Les champs immatriculation et marque sont obligatoires.");
        }

        $sql = "UPDATE vehicules SET vin=:vin, immatriculation=:immatriculation, type=:type, marque=:marque, modele=:modele, couleur=:couleur,
                puissance=:puissance, nombre_places=:nombre_places, nombre_portieres=:nombre_portieres, date_mise_circulation=:date_mise_circulation,
                carburant=:carburant, kilometrage=:kilometrage, statut=:statut, id_parc=:id_parc
                WHERE id_vehicule=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':vin' => $vin,
            ':immatriculation' => $immatriculation,
            ':type' => $type,
            ':marque' => $marque,
            ':modele' => $modele,
            ':couleur' => $couleur,
            ':puissance' => $puissance,
            ':nombre_places' => $nombre_places,
            ':nombre_portieres' => $nombre_portieres,
            ':date_mise_circulation' => $date_mise_circulation,
            ':carburant' => $carburant,
            ':kilometrage' => $kilometrage,
            ':statut' => $statut,
            ':id_parc' => $id_parc,
            ':id' => $id
        ]);
        $success = "Véhicule mis à jour avec succès.";
        header("Location: vehicules.php");
        exit;
    } catch (PDOException $e) {
        $error = "Erreur base de données : " . $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

/* -------------------
   SUPPRESSION D'UN VÉHICULE
   ------------------- */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        // Interdire suppression si lié à au moins un contrat
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM contrats WHERE id_vehicule = ?");
        $stmt->execute([$id]);
        $count = (int)$stmt->fetchColumn();
        if ($count > 0) {
            $error = "Impossible de supprimer : le véhicule est lié à des contrats.";
        } else {
            $stmt = $pdo->prepare("DELETE FROM vehicules WHERE id_vehicule = ?");
            $stmt->execute([$id]);
            $success = "Véhicule supprimé.";
            header("Location: vehicules.php");
            exit;
        }
    } catch (PDOException $e) {
        $error = "Erreur lors de la suppression : " . $e->getMessage();
    }
}

/* -------------------
   RÉCUPÉRATION POUR ÉDITION
   ------------------- */
$editVehicle = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM vehicules WHERE id_vehicule = ?");
    $stmt->execute([$id]);
    $editVehicle = $stmt->fetch();
}

/* -------------------
   LISTING (avec recherche / filtre)
   ------------------- */
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';

$where = [];
$params = [];

if ($q !== '') {
    $where[] = "(immatriculation LIKE :q OR marque LIKE :q OR modele LIKE :q)";
    $params[':q'] = "%{$q}%";
}
if ($statusFilter !== '') {
    $where[] = "statut = :statut";
    $params[':statut'] = $statusFilter;
}

$whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT v.*, p.nom AS parc_nom
        FROM vehicules v
        LEFT JOIN parc_auto p ON p.id_parc = v.id_parc
        $whereSql
        ORDER BY v.id_vehicule DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vehicules = $stmt->fetchAll();

function badgeClass($statut) {
    switch ($statut) {
        case 'disponible': return 'bg-success';
        case 'loué': return 'bg-warning text-dark';
        case 'vendu': return 'bg-secondary';
        case 'maintenance': return 'bg-info text-dark';
        default: return 'bg-light text-dark';
    }
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Véhicules</h2>
        <a href="dashboard.php" class="btn btn-outline-secondary">← Retour</a>
    </div>

```
<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="card shadow-sm mb-4">
    <div class="card-header">
        <?php if ($editVehicle): ?>
            <strong>Modifier le véhicule #<?= htmlspecialchars($editVehicle['id_vehicule']) ?></strong>
        <?php else: ?>
            <strong>Ajouter un véhicule</strong>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($editVehicle): ?>
            <form method="post" class="row g-3">
                <input type="hidden" name="id_vehicule" value="<?= (int)$editVehicle['id_vehicule'] ?>">
                <div class="col-md-4">
                    <label class="form-label">Immatriculation *</label>
                    <input type="text" name="immatriculation" class="form-control" value="<?= htmlspecialchars($editVehicle['immatriculation']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Marque *</label>
                    <input type="text" name="marque" class="form-control" value="<?= htmlspecialchars($editVehicle['marque']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Modèle</label>
                    <input type="text" name="modele" class="form-control" value="<?= htmlspecialchars($editVehicle['modele']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($editVehicle['type']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">VIN</label>
                    <input type="text" name="vin" class="form-control" value="<?= htmlspecialchars($editVehicle['vin']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Couleur</label>
                    <input type="text" name="couleur" class="form-control" value="<?= htmlspecialchars($editVehicle['couleur']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kilométrage</label>
                    <input type="number" name="kilometrage" class="form-control" value="<?= htmlspecialchars($editVehicle['kilometrage']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select">
                        <?php foreach (['disponible','loué','vendu','maintenance'] as $s): ?>
                            <option value="<?= $s ?>" <?= ($editVehicle['statut']==$s)?'selected':''; ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" name="update_vehicle" class="btn btn-primary">Enregistrer les modifications</button>
                    <a href="vehicules.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        <?php else: ?>
            <form method="post" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Immatriculation *</label>
                    <input type="text" name="immatriculation" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Marque *</label>
                    <input type="text" name="marque" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Modèle</label>
                    <input type="text" name="modele" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <input type="text" name="type" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">VIN</label>
                    <input type="text" name="vin" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Couleur</label>
                    <input type="text" name="couleur" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kilométrage</label>
                    <input type="number" name="kilometrage" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select">
                        <option value="disponible">Disponible</option>
                        <option value="loué">Loué</option>
                        <option value="vendu">Vendu</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" name="add_vehicle" class="btn btn-success">Ajouter le véhicule</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Recherche / filtre -->
<div class="row mb-3">
    <div class="col-md-8">
        <form method="get" class="d-flex">
            <input type="text" name="q" class="form-control me-2" placeholder="Rechercher par immatriculation, marque ou modèle" value="<?= htmlspecialchars($q) ?>">
            <select name="status" class="form-select me-2" style="max-width:200px;">
                <option value="">Tous statuts</option>
                <option value="disponible" <?= ($statusFilter=='disponible')?'selected':''; ?>>Disponible</option>
                <option value="loué" <?= ($statusFilter=='loué')?'selected':''; ?>>Loué</option>
                <option value="vendu" <?= ($statusFilter=='vendu')?'selected':''; ?>>Vendu</option>
                <option value="maintenance" <?= ($statusFilter=='maintenance')?'selected':''; ?>>Maintenance</option>
            </select>
            <button class="btn btn-outline-primary">Filtrer</button>
        </form>
    </div>
</div>

<!-- Listing -->
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Immatriculation</th>
                <th>Marque / Modèle</th>
                <th>Type</th>
                <th>Kms</th>
                <th>Parc</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($vehicules)): ?>
                <tr><td colspan="8" class="text-center">Aucun véhicule trouvé.</td></tr>
            <?php else: ?>
                <?php foreach ($vehicules as $v): ?>
                    <tr>
                        <td><?= (int)$v['id_vehicule'] ?></td>
                        <td><?= htmlspecialchars($v['immatriculation']) ?></td>
                        <td><?= htmlspecialchars($v['marque'] . ' ' . $v['modele']) ?></td>
                        <td><?= htmlspecialchars($v['type']) ?></td>
                        <td><?= htmlspecialchars($v['kilometrage']) ?></td>
                        <td><?= htmlspecialchars($v['parc_nom']) ?></td>
                        <td><span class="badge <?= badgeClass($v['statut']) ?>"><?= ucfirst($v['statut']) ?></span></td>
                        <td>
                            <a href="vehicules.php?edit=<?= (int)$v['id_vehicule'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <a href="vehicules.php?delete=<?= (int)$v['id_vehicule'] ?>" class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Confirmer la suppression du véhicule <?= htmlspecialchars($v['immatriculation']) ?> ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
```

</div>

<?php include "templates/footer.php"; ?>

?>
