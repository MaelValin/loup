<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Joueur.php");

/**
 *  Classe JoueurRepository
 * 
 *  Cette classe represente le "stock" de Joueur.
 *  Toutes les operations sur les Joueur doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en consequence.
 * 
 *  La classe herite de EntityRepository ce qui oblige à definir les methodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des methodes supplementaires si
 *  c'est utile !
 *  
 */
class JoueurRepository extends EntityRepository {

    public function __construct(){
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }

    public function find($id): ?Joueur {
        $requete = $this->cnx->prepare("SELECT * FROM joueur WHERE id_joueur=:value");
        $requete->bindParam(':value', $id);
        $requete->execute();
        $answer = $requete->fetch(PDO::FETCH_OBJ);
        
        if ($answer == false) return null;
        
        $joueur = new Joueur($answer->id_joueur, $answer->id_perso, $answer->nom, $answer->ville);
        return $joueur;
    }

    public function findAll(): array {
        $requete = $this->cnx->prepare("SELECT * FROM joueur ORDER BY nom ASC");
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $joueur = new Joueur($obj->id_joueur, $obj->id_perso, $obj->nom, $obj->ville);
            array_push($res, $joueur);
        }
       
        return $res;
    }

    public function listall(){
        $requete = $this->cnx->prepare("SELECT joueur.nom AS joueur_nom, 
       joueur.ville, 
       perso.nom AS perso_nom, 
       perso.img,
       perso.tour,
       perso.ordre
FROM joueur
INNER JOIN perso ON joueur.id_perso = perso.id_perso order by perso.ordre asc"); 
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);
        return $answer;
    }


    public function list($ville){
        $requete = $this->cnx->prepare("SELECT joueur.nom AS joueur_nom, 
       joueur.ville, 
       perso.nom AS perso_nom, 
       perso.img,
       perso.tour,
       perso.ordre
FROM joueur
INNER JOIN perso ON joueur.id_perso = perso.id_perso
where perso.tour!=-1 and joueur.ville='$ville' order by perso.ordre asc"); 
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);
        return $answer;
    }

    public function listimpair(){
        $requete = $this->cnx->prepare("SELECT joueur.nom AS joueur_nom, 
       joueur.ville, 
       perso.nom AS perso_nom, 
       perso.img,
       perso.tour,
       perso.ordre
FROM joueur
INNER JOIN perso ON joueur.id_perso = perso.id_perso
where perso.tour=0 or perso.tour=2 and joueur.ville='$ville' order by perso.ordre asc"); 
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);
        return $answer;
    }

    public function listpair(){
        $requete = $this->cnx->prepare("SELECT joueur.nom AS joueur_nom, 
       joueur.ville, 
       perso.nom AS perso_nom, 
       perso.img,
       perso.tour,
       perso.ordre
FROM joueur
INNER JOIN perso ON joueur.id_perso = perso.id_perso
where perso.tour=0 and joueur.ville='$ville' order by perso.ordre asc"); 
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);
        return $answer;
    }



    public function save($entity) {
        if (!isset($entity['id_perso'], $entity['nom'], $entity['ville'])) {
            throw new InvalidArgumentException('Paramètres incomplets pour le joueur.');
        }
    
        try {
            $requete = $this->cnx->prepare("INSERT INTO `joueur` (`id_perso`, `nom`, `ville`) VALUES (:perso, :nom, :ville)");
            $requete->bindParam(':perso', $entity['id_perso']);
            $requete->bindParam(':nom', $entity['nom']);
            $requete->bindParam(':ville', $entity['ville']);
            $requete->execute();
    
            return $this->cnx->lastInsertId();
        } catch (PDOException $e) {
            throw new RuntimeException('Erreur lors de l\'insertion : ' . $e->getMessage());
        }
    }
    

    public function delete($id){
        // Not implemented ! TODO when needed !
        return false;
    }

    public function deleteAll() {
        try {
            $requete = $this->cnx->prepare("DELETE FROM joueur");
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            throw new RuntimeException('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function deleteByville($ville) {
        try {
            $requete = $this->cnx->prepare("DELETE FROM joueur WHERE ville = :ville");
            $requete->bindParam(':ville', $ville);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            throw new RuntimeException('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }



    

    public function update($joueur){
        // Not implemented ! TODO when needed !
        return false;
    }

}
