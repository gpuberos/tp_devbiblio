<?php

class Livre
{
    private int $id; // Identifiant du livre
    private string $titre; // Titre du livre
    private int $nbPages; // Nombre de pages du livre
    private string $image; // Image du livre

    // Constructeur de la classe Livre
    public function __construct(int $id, string $titre, int $nbPages, string $image)
    {
        $this->id = $id; // Initialisation de l'identifiant du livre
        $this->titre = $titre; // Initialisation du titre du livre
        $this->nbPages = $nbPages; // Initialisation du nombre de pages du livre
        $this->image = $image; // Initialisation de l'image du livre
    }

    // Méthode pour obtenir l'identifiant du livre
    public function getId(): int
    {
        return $this->id;
    }

    // Méthode pour définir l'identifiant du livre
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Méthode pour obtenir le titre du livre
    public function getTitre(): string
    {
        return $this->titre;
    }

    // Méthode pour définir le titre du livre
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    // Méthode pour obtenir le nombre de pages du livre
    public function getNbPages(): int
    {
        return $this->nbPages;
    }

    // Méthode pour définir le nombre de pages du livre
    public function setNbPages(int $nbPages): void
    {
        $this->nbPages = $nbPages;
    }

    // Méthode pour obtenir l'image du livre
    public function getImage(): string
    {
        return $this->image;
    }

    // Méthode pour définir l'image du livre
    public function setImage(string $image): void
    {
        $this->image = $image;
    }
}
