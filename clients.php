<?php include "auth.php"; include "config/db.php"; include "templates/header.php"; ?>

<div class="container mt-4">
  <h2>Clients</h2>

  <!-- Formulaire ajout -->
  <form method="post">
    <input type="text" name="nom" placeholder="Nom" class="form-control mb-2" required>
    <input type="text" name="prenom" placeholder="Prénom" class="form-control mb-2">
    <input type="text" name="telephone" placeholder="Téléphone" class="form-control mb-2">
    <input type="email" name="email" placeholder="Email" class="form-control mb-2">
    <button class="btn btn-success">Ajouter</button>
  </form>

  <?php
  // Insertion
  if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["nom"])) {
      $stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, telephone, email) VALUES (?, ?, ?, ?)");
      $stmt->execute([$_POST["nom"], $_POST["prenom"], $_POST["telephone"], $_POST["email"]]);
      header("Location: clients.php");
  }

  // Suppression
  if (isset($_GET["delete"])) {
      $stmt = $pdo->prepare("DELETE FROM clients WHERE id=?");
      $stmt->execute([$_GET["delete"]]);
      header("Location: clients.php");
  }

  // Affichage
  $clients = $pdo->query("SELECT * FROM clients")->fetchAll();
  ?>
  <table class="table mt-3">
    <tr><th>ID</th><th>Nom</th><th>Email</th><th>Action</th></tr>
    <?php foreach ($clients as $c): ?>
      <tr>
        <td><?= $c["id"] ?></td>
        <td><?= $c["nom"]." ".$c["prenom"] ?></td>
        <td><?= $c["email"] ?></td>
        <td>
          <a href="?delete=<?= $c["id"] ?>" class="btn btn-danger btn-sm">Supprimer</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php include "templates/footer.php"; ?>
