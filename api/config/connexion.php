<?php
abstract class Connexion
{
    /**
     * Undocumented variable
     *
     * @var PDO|null
     */
    private static $pdo;

    private static function setBdd()
    {
        try {
            self::$pdo = new PDO('mysql:host=localhost;dbname=gestion_coloc;charset=utf8', 'root', '');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion réussie à la base de données.";
        } catch (PDOException $e) {
            die('Erreur de connexion à la base : ' . $e->getMessage());
        }
    }

    protected function getBdd()
    {
        if (self::$pdo === null) {
            self::setBdd();
        }
        return self::$pdo;
    }
}
?>

