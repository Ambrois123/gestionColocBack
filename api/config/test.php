<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'connexion.php'; // ou le chemin exact vers ta classe

// test basique
echo "Ce fichier est exécuté.<br>";

// si Connexion est une classe abstraite, tu peux faire un appel simplifié
try {
    $pdo = new PDO('mysql:host=localhost;dbname=gestion_coloc;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données.";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>