<?php 
include "auth.php"; 
include "config/db.php"; 
include "templates/header.php"; 

// --- AJOUT D'UNE VENTE ---
if (isset($_POST["ajouter"])) {
    $stmt = $pdo->prepare("INSERT INTO contrats (type_contrat, date_debut, prix, id_client, id_vehicule, id_vendeur) 
                           VALUES ('vente', NOW(), ?, ?, ?, ?)");
    $stmt->execute([$_POST["prix"], $_POST["client"], $_POST["vehicule"], 1]); // vendeur fixe=1 pour simplifier
    $pdo->query("UPDATE vehicules SET statut='vendu' WHERE id_vehicule=".(int)$_POST["vehicule"]);
    header("Location: ventes.php");
}

// --- SUPPRESSION D'UNE VENTE ---
if (isset($_GET["delete"])) {
    $stmt = $pdo->prepare("DELETE FROM contrats WHERE id_contrat=? AND type_contrat='vente'");
    $stmt->execute([$_GET["delete"]]);
    header("Location: ventes.php");
}

// --- LISTES ---
$clients = $pdo->query("SELECT id, nom, prenom FROM clients")->fetchAll();
$vehicules = $pdo->query("SELECT id_vehicule, immatriculation, marque, modele FROM vehicules WHERE statut='disponible'")->fetchAll();
$ventes = $pdo->query("SELECT c.id_contrat, c.prix, c.date_debut, cl.nom, cl.prenom, v.marque, v.modele, v.immatriculation 
                       FROM contrats c 
                       JOIN clients cl ON cl.id=c.id_client
                       JOIN vehicules v ON v.id_vehicule=c.id_vehicule
                       WHERE c.type_contrat='vente'
                       ORDER BY c.date_debut DESC")->fetchAll();
?>

<div class="container mt-4">
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
      <h3>Nouvelle Vente</h3>
    </div>
    <div class="card-body">
      <form method="post" class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Client</label>
          <select name="client" class="form-select" required>
            <option value="">-- Choisir client --</option>
            <?php foreach($clients as $c): ?>
              <option value="<?= $c["id"] ?>"><?= $c["nom"]." ".$c["prenom"] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
          <label class="form-label">Prix</label>
          <input type="number" step="0.01" name="prix" class="form-control" required>
        </div>
        <div class="col-12 text-end">
          <button type="submit" name="ajouter" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Enregistrer la vente
          </button>
        </div>
      </form>
    </div>
  </div>

  <h3 class="mt-5">Liste des ventes</h3>
  <table class="table table-striped table-hover shadow-sm mt-3">
    <thead class="table-dark">
      <tr>
        <th>ID</th><th>Date</th><th>Client</th><th>Véhicule</th><th>Prix</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($ventes as $v): ?>
        <tr>
          <td><?= $v["id_contrat"] ?></td>
          <td><?= $v["date_debut"] ?></td>
          <td><?= $v["nom"]." ".$v["prenom"] ?></td>
          <td><?= $v["marque"]." ".$v["modele"]." (".$v["immatriculation"].")" ?></td>
          <td><span class="badge bg-success"><?= number_format($v["prix"],2,","," ") ?> €</span></td>
          <td>
            <a href="?delete=<?= $v["id_contrat"] ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('Supprimer cette vente ?')">
               <i class="bi bi-trash"></i> Supprimer
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include "templates/footer.php"; ?>
