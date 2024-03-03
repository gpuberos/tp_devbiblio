<?php

// Démarrage de la session
session_start();

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

// Inclure le contrôleur des livres
require_once "controllers/LivresController.controller.php";
// Créer une nouvelle instance du contrôleur des livres
$livreController = new LivresController;

// Routeur
try {
    // Si aucune page n'est spécifiée, afficher la page d'accueil
    if (empty($_GET['page'])) {
        require_once "views/accueil.view.php";
    } else {
        // Sinon, décomposer l'URL en segments
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);

        // En fonction du premier segment de l'URL
        switch ($url[0]) {
            case 'accueil':
                // Afficher la page d'accueil
                require_once "views/accueil.view.php";
                break;
            case 'livres':
                // Si aucun sous-segment n'est spécifié, afficher tous les livres
                if (empty($url[1])) {
                    $livreController->viewLivres();
                } else if ($url[1] === "details") {
                    // Si le sous-segment est "details", afficher le livre spécifié
                    $livreController->viewLivre($url[2]);
                } else if ($url[1] === "add") {
                    // Si le sous-segment est "add", afficher le formulaire d'ajout de livre
                    $livreController->addLivre();
                } else if ($url[1] === "update") {
                    // Si le sous-segment est "update", afficher le formulaire de mise à jour du livre spécifié
                    $livreController->updateLivre($url[2]);
                } else if ($url[1] === "delete") {
                    // Si le sous-segment est "delete", supprimer le livre spécifié
                    $livreController->deleteLivre($url[2]);
                } else if ($url[1] === "addvalid") {
                    // Si le sous-segment est "addvalid", valider l'ajout d'un livre
                    $livreController->addLivreValidation();
                } else if ($url[1] === "updatevalid") {
                    // Si le sous-segment est "updatevalid", valider la mise à jour d'un livre
                    $livreController->updateLivreValidation();
                } else {
                    // Si le sous-segment n'est pas reconnu, lancer une exception
                    throw new Exception("La page n'existe pas");
                }
                break;
            default:
                // Si le premier segment de l'URL n'est pas reconnu, lancer une exception
                throw new Exception("La page n'existe pas");
                break;
        }
    }
} catch (Exception $e) {
    // Si une exception est lancée, afficher la page d'erreur
    $msg = $e->getMessage();
    require_once "views/error.view.php";
}
