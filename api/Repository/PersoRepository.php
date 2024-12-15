<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Perso.php");

/**
 *  Classe PersoRepository
 * 
 *  Cette classe represente le "stock" de Perso.
 *  Toutes les operations sur les Perso doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en consequence.
 * 
 *  La classe herite de EntityRepository ce qui oblige à definir les methodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des methodes supplementaires si
 *  c'est utile !
 *  
 */
class PersoRepository extends EntityRepository {

    public function __construct(){
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }

    public function find($id): ?Perso {
        $requete = $this->cnx->prepare("select * from perso where id_perso=:value");
        $requete->bindParam(':value', $id);
        $requete->execute();
        $answer = $requete->fetch(PDO::FETCH_OBJ);
        
        if ($answer == false) return null;
        
        $perso = new Perso($answer->id_perso, $answer->img, $answer->nom, $answer->effet, $answer->ordre, $answer->tour);
        return $perso;
    }

    public function findAll(): array {
        $requete = $this->cnx->prepare("select * from perso order by nom asc");
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $perso = new Perso($obj->id_perso, $obj->img, $obj->nom, $obj->effet, $obj->ordre, $obj->tour);
            array_push($res, $perso);
        }
       
        return $res;
    }

    public function list(){
        $requete = $this->cnx->prepare("SELECT nom, tour FROM `perso` 
WHERE `ordre` != 0 
ORDER BY `ordre` ASC;
"); 
    $requete->execute();
    $answer = $requete->fetchAll(PDO::FETCH_OBJ);
    return $answer;
    }

    public function save($perso){
        // Not implemented ! TODO when needed !          
        return false;
    }

    public function delete($id){
        // Not implemented ! TODO when needed !
        return false;
    }

    public function update($perso){
        // Not implemented ! TODO when needed !
        return false;
    }

}
