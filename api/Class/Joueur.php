<?php
/**
 *  Class Joueur
 * 
 *  Represents a player with properties (id_joueur, id_perso, nom, ville)
 * 
 *  Implements the JsonSerializable interface 
 *  which requires defining a jsonSerialize method. This method specifies how objects
 *  of the Joueur class should be converted to JSON. See the method for more details.
 */
class Joueur implements JsonSerializable {
    private int $id_joueur;
    private int $id_perso;
    private string $nom;
    private string $ville;

    public function __construct(int $id_joueur, int $id_perso, string $nom, string $ville){
        $this->id_joueur = $id_joueur;
        $this->id_perso = $id_perso;
        $this->nom = $nom;
        $this->ville = $ville;
    }

    /**
     * Get the value of id_joueur
     */ 
    public function getIdJoueur(): int
    {
        return $this->id_joueur;
    }

    /**
     * Get the value of id_perso
     */ 
    public function getIdPerso(): int
    {
        return $this->id_perso;
    }

    /**
     * Set the value of id_perso
     *
     * @return  self
     */ 
    public function setIdPerso(int $id_perso): self
    {
        $this->id_perso = $id_perso;
        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get the value of ville
     */ 
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * Set the value of ville
     *
     * @return  self
     */ 
    public function setVille(string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function jsonSerialize(): array {
        return [
            "id_joueur" => $this->id_joueur,
            "id_perso" => $this->id_perso,
            "nom" => $this->nom,
            "ville" => $this->ville
        ];
    }
}
