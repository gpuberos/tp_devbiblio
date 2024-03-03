<?php

// Inclusion des classes Model & Livre
require_once "Model.class.php";
require_once "Livre.class.php";

// Définition de la classe LivreManager qui hérite de la classe Model
class LivreManager extends Model
{
    // Déclaration d'une propriété privée pour stocker une liste de livres (tableau)
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
        foreach ($livresDepuisBDD as $livre) {
            // Création d'un nouvel objet Livre avec les informations du livre
            $l = new Livre($livre['id'], $livre['titre'], $livre['nbPages'], $livre['image']);
            // Ajout du nouvel objet Livre à la liste des livres
            $this->addLivre($l);
        }
    }

    // Méthode pour obtenir un livre par son id
    public function getLivreById(int $id)
    {
        // Parcourir chaque livre dans la liste des livres
        foreach ($this->listeLivres as $livre) {
            // Si l'ID du livre correspond à l'ID recherché
            if ($livre->getId() === $id) {
                // Retourner le livre correspondant
                return $livre;
            }
        }
        // S'il n'existe pas retourne null
        return null;
    }

    public function addLivreBdd($titre, $nbPages, $image)
    {
        $req = "INSERT INTO livres (`titre`, `nbPages`, `image`)
        VALUES (:titre, :nbPages, :image)";
        $sth = $this->getBdd()->prepare($req);
        $sth->bindValue(":titre", $titre, PDO::PARAM_STR);
        $sth->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
        $sth->bindValue(":image", $image, PDO::PARAM_STR);
        $result = $sth->execute();
        $sth->closeCursor();

        if ($result > 0) {
            $id = $this->getBdd()->lastInsertId();
            $livre = new Livre($id, $titre, $nbPages, $image);
            $this->addLivre($livre);
        } else {
            throw new Exception("L'ajout du livre à la base de données a échoué");
        }
    }
}
