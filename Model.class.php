<?php

/* 
Class abstraite Model : elle ne sera jamais instanciable directement, 
cette class va être héritée directement des autres classe qui auront besoin d'accéder aux données.
*/
abstract class Model
{
    private static $pdo;

    private static function setBdd()
    {
        require_once 'config/config.php';
        
        $dsn = "mysql:host={$config['database']['db_host']};
                dbname={$config['database']['db_name']};
                charset={$config['database']['db_char']};
                port={$config['database']['db_port']}";
        
        self::$pdo = new PDO($dsn, $config['database']['db_user'], $config['database']['db_pass']);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    protected function getBdd()
    {
        if (self::$pdo === null) {
            self::setBdd();
        }
        return self::$pdo;
    }
}
