<?php 
include "auth.php"; 
include "config/db.php"; 
include "templates/header.php"; 

// --- AJOUT D'UNE LOCATION ---
if (isset($_POST["ajouter"])) {
    $stmt = $pdo->prepare("INSERT INTO contrats (type_contrat, date_debut, date_fin, prix, id_client, id_vehicule, id_vendeur) 
                           VALUES ('location', ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_POST["date_debut"], $_POST["date_fin"], $_POST["prix"], $_POST["client"], $_POST["vehicule"], 1]);
    $pdo->query("UPDATE vehicules SET statut='loué' WHERE id_vehicule=".(int)$_POST["vehicule"]);
    header("Location: locations.php");
}

// --- SUPPRESSION D'UNE LOCATION ---
if (isset($_GET["delete"])) {
    $stmt = $pdo->prepare("DELETE FROM contrats WHERE id_contrat=? AND type_contrat='location'");
    $stmt->execute([$_GET["delete"]]);
    header("Location: locations.php");
}

// --- LISTES ---
$clients = $pdo->query("SELECT id, nom, prenom FROM clients")->fetchAll();
$vehicules = $pdo->query("SELECT id_vehicule, immatriculation, marque, modele FROM vehicules WHERE statut='disponible'")->fetchAll();
$locations = $pdo->query("SELECT c.id_contrat, c.prix, c.date_debut, c.date_fin, cl.nom, cl.prenom, v.marque, v.modele, v.immatriculation 
                          FROM contrats c 
                          JOIN clients cl ON cl.id=c.id_client
                          JOIN vehicules v ON v.id_vehicule=c.id_vehicule
                          WHERE c.type_contrat='location'
                          ORDER BY c.date_debut DESC")->fetchAll();
?>

<div class="container mt-4">
  <div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
      <h3>Nouvelle Location</h3>
    </div>
    <div class="card-body">
      <form method="post" class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Client</label>
          <select name="client" class="form-select" required>
            <option value="">-- Choisir client --</option>
            <?php foreach($clients as $c): ?>
              <option value="<?= $c["id"] ?>"><?= $c["nom"]." ".$c["prenom"] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Véhicule</label>
          <select name="vehicule" class="form-select" required>
            <option value="">-- Choisir véhicule --</option>
            <?php foreach($vehicules as $v): ?>
              <option value="<?= $v["id_vehicule"] ?>">
                <?= $v["marque"]." ".$v["modele"]." (".$v["immatriculation"].")" ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Début</label>
          <input type="date" name="date_debut" class="form-control" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Fin</label>
          <input type="date" name="date_fin" class="form-control" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Prix</label>
          <input type="number" step="0.01" name="prix" class="form-control" required>
        </div>
        <div class="col-12 text-end">
          <button type="submit" name="ajouter" class="btn btn-primary">
            <i class="bi bi-calendar-plus"></i> Enregistrer la location
          </button>
        </div>
      </form>
    </div>
  </div>

  <h3 class="mt-5">Liste des locations</h3>
  <table class="table table-striped table-hover shadow-sm mt-3">
    <thead class="table-primary">
      <tr>
        <th>ID</th><th>Début</th><th>Fin</th><th>Client</th><th>Véhicule</th><th>Prix</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($locations as $l): ?>
        <tr>
          <td><?= $l["id_contrat"] ?></td>
          <td><?= $l["date_debut"] ?></td>
          <td><?= $l["date_fin"] ?></td>
          <td><?= $l["nom"]." ".$l["prenom"] ?></td>
          <td><?= $l["marque"]." ".$l["modele"]." (".$l["immatriculation"].")" ?></td>
          <td><span class="badge bg-info"><?= number_format($l["prix"],2,","," ") ?> €</span></td>
          <td>
            <a href="?delete=<?= $l["id_contrat"] ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('Supprimer cette location ?')">
               <i class="bi bi-trash"></i> Supprimer
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include "templates/footer.php"; ?>
