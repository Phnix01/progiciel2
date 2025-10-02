<?php
session_start();
include "config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // DEBUG - À ajouter temporairement
    echo "<pre>";
    echo "Email recherché: " . $email . "\n";
    echo "Utilisateur trouvé: " . ($user ? "OUI" : "NON") . "\n";
    if ($user) {
        echo "Hash en BDD: " . $user["password"] . "\n";
        echo "Vérification mot de passe: " . (password_verify($password, $user["password"]) ? "OK" : "ECHEC") . "\n";
    }
    echo "</pre>";
    // Fin du debug

    if ($user && password_verify($password, $user["password"])) {
        // ...
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2>Connexion Admin</h2>
  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="password" name="password" class="form-control mb-2" placeholder="Mot de passe" required>
    <button class="btn btn-primary">Se connecter</button>
  </form>
</body>
</html>
