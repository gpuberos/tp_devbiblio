<?php

/* 
Class abstraite Model : elle ne sera jamais instanciable directement, 
cette class va être héritée directement des autres classe qui auront besoin d'accéder aux données.
*/
abstract class Model
{
    private static ?PDO $pdo = null; // Instance de PDO pour la connexion à la base de données

    // Méthode pour configurer la base de données
    private static function setBdd(): void
    {
        require_once 'config/config.php'; // Inclure le fichier de configuration de la base de données
        
        // Créer la chaîne de connexion pour PDO
        $dsn = "mysql:host={$config['database']['db_host']};
                dbname={$config['database']['db_name']};
                charset={$config['database']['db_char']};
                port={$config['database']['db_port']}";
        
        // Créer une nouvelle instance de PDO avec la chaîne de connexion et les identifiants de la base de données
        self::$pdo = new PDO($dsn, $config['database']['db_user'], $config['database']['db_pass']);
        // Configurer PDO pour afficher des avertissements en cas d'erreur
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    // Méthode pour obtenir l'instance de PDO
    protected function getBdd(): PDO
    {
        // Si l'instance de PDO n'a pas encore été créée, la configurer
        if (self::$pdo === null) {
            self::setBdd();
        }
        // Retourner l'instance de PDO
        return self::$pdo;
    }
}
