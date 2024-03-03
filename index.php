<?php

// Vérifie si le protocole HTTPS est utilisé. Si oui, définissez $protocol sur "https", sinon sur "http"
$protocol = isset($_SERVER['HTTPS']) ? "https" : "http";

// Stocke le nom d'hôte dans la variable $host
$host = $_SERVER['HTTP_HOST'];

// Stocke le chemin d'accès au script côté serveur dans la variable $self
$self = $_SERVER['PHP_SELF'];

// Définissez la constante URL
// str_replace est utilisé pour remplacer "index.php" par une chaîne vide dans l'URL
// L'URL est construite en utilisant le protocole, le nom d'hôte et le chemin d'accès au script côté serveur
// URL = {$protocol}://{$host}{$self} soit https://monsite/pages/mapage.php
define("URL", str_replace("index.php", "", "{$protocol}://{$host}{$self}"));


require_once "controllers/LivresController.controller.php";
$livreController = new LivresController;

// Routeur

try {
    if (empty($_GET['page'])) {
        require_once "views/accueil.view.php";
    } else {
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);

        switch ($url[0]) {
            case 'accueil':
                require_once "views/accueil.view.php";
                break;
            case 'livres':
                if (empty($url[1])) {
                    $livreController->viewLivres();
                } else if ($url[1] === "details") {
                    $livreController->viewLivre($url[2]);
                } else if ($url[1] === "add") {
                    $livreController->addLivre();
                } else if ($url[1] === "modify") {
                    echo "modifier un livre";
                } else if ($url[1] === "delete") {
                    $livreController->deleteLivre($url[2]);
                } else if ($url[1] === "addvalid") {
                    $livreController->addLivreValidation();
                } else {
                    throw new Exception("La page n'existe pas");
                }
                break;
            default:
                throw new Exception("La page n'existe pas");
                break;
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
