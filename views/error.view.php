<?php ob_start(); // Ouverture du buffer PHP pour mettre en temporisation du code pour plutard

echo $msg;

$content = ob_get_clean(); // Va déverser tout ce qui est dans la variable $content (entre ob_start() et ob_get_clean())

$titre = "Erreur !";
require_once "template.php";
