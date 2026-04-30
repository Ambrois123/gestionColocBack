<?php
abstract class Connexion
{
    private static $pdo;

    private static function setBdd()
    {
        self::$pdo = new PDO('mysql:host=localhost;dbname=gestion_coloc;charset=utf8', 'root', '');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        echo "Connexion réussie à la base de données.";
    }

    protected function getBdd()
    {
        if(self::$pdo == null)
        {
            self::setBdd();
        }
        
        return self::$pdo;
    }
}
?>

