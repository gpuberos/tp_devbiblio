<?php

// Inclusion des classes Model & Livre
require_once "Model.class.php";
require_once "Livre.class.php";

// Définition de la classe LivreManager qui hérite de la classe Model
class LivreManager extends Model
{
    // Déclaration d'une propriété privée pour stocker une liste de livres
    private $listeLivres;

    // Méthode pour ajouter un livre à la liste
    public function addLivre($livre)
    {
        // Ajout du livre passé en paramètre à la liste des livres
        $this->listeLivres[] = $livre;
    }

    // Méthode pour obtenir la liste des livres
    public function getLivres()
    {
        // Retourne la liste des livres
        return $this->listeLivres;
    }

    // Méthode pour charger les livres depuis la base de données
    public function loadLivres()
    {
        // Préparation de la requête SQL pour sélectionner tous les livres
        $req = $this->getBdd()->prepare("SELECT * FROM livres");
        // Exécution de la requête
        $req->execute();
        // Récupération de tous les livres sous forme d'un tableau associatif
        $livresDepuisBDD = $req->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture du curseur de la requête
        $req->closeCursor();

        // Parcours de chaque livre récupéré depuis la base de données
        foreach($livresDepuisBDD as $livre) {
            // Création d'un nouvel objet Livre avec les informations du livre
            $l = new Livre($livre['id'], $livre['titre'], $livre['nbPages'], $livre['image']);
            // Ajout du nouvel objet Livre à la liste des livres
            $this->addLivre($l);
        }
    }
}
