<?php
// reset_password.php - À exécuter une seule fois
include "config/db.php";

$nouveau_mot_de_passe = "admin123"; // Choisissez un nouveau mot de passe
$hash = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->execute([$hash, "admin@garage.com"]);

echo "Mot de passe réinitialisé !\n";
echo "Nouveau mot de passe: admin123\n";
echo "Hash: " . $hash;
?>