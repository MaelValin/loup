<?php
/**
 *  Class Perso
 * 
 *  Represente un personnage avec ses propriétés (id_perso, img, nom, effet, ordre, tour)
 * 
 *  Implémente l'interface JsonSerializable 
 *  qui oblige à définir une méthode jsonSerialize. Cette méthode permet de dire comment les objets
 *  de la classe Perso doivent être converti en JSON. Voire la méthode pour plus de détails.
 */
class Perso implements JsonSerializable {
    private int $id_perso;
    private string $img;
    private string $nom;
    private string $effet;
    private int $ordre;
    private int $tour;

    public function __construct(int $id_perso, string $img, string $nom, string $effet, int $ordre, int $tour){
        $this->id_perso = $id_perso;
        $this->img = $img;
        $this->nom = $nom;
        $this->effet = $effet;
        $this->ordre = $ordre;
        $this->tour = $tour;
    }

    /**
     * Get the value of id_perso
     */ 
    public function getIdPerso(): int
    {
        return $this->id_perso;
    }

    /**
     * Get the value of img
     */ 
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */ 
    public function setImg(string $img): self
    {
        $this->img = $img;
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
     * Get the value of effet
     */ 
    public function getEffet(): string
    {
        return $this->effet;
    }

    /**
     * Set the value of effet
     *
     * @return  self
     */ 
    public function setEffet(string $effet): self
    {
        $this->effet = $effet;
        return $this;
    }

    /**
     * Get the value of ordre
     */ 
    public function getOrdre(): int
    {
        return $this->ordre;
    }

    /**
     * Set the value of ordre
     *
     * @return  self
     */ 
    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;
        return $this;
    }

    /**
     * Get the value of tour
     */ 
    public function getTour(): int
    {
        return $this->tour;
    }

    /**
     * Set the value of tour
     *
     * @return  self
     */ 
    public function setTour(int $tour): self
    {
        $this->tour = $tour;
        return $this;
    }

    public function jsonSerialize(): array {
        return [
            "id_perso" => $this->id_perso,
            "img" => $this->img,
            "nom" => $this->nom,
            "effet" => $this->effet,
            "ordre" => $this->ordre,
            "tour" => $this->tour
        ];
    }
}
