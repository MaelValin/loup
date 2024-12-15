<?php
require_once "Controller.php";
require_once "Repository/JoueurRepository.php";

// This class inherits the jsonResponse method and the $cnx property from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class JoueurController extends Controller {

    private JoueurRepository $joueur;

    public function __construct(){
        $this->joueur = new JoueurRepository();
    }

    protected function processGetRequest(HttpRequest $request) {

        $stat = $request->getParam('stat');
        if ($stat=='listall'){
            return $this->joueur->listall();
        }
        $stat = $request->getParam('stat');
        if ($stat=='list'){
            return $this->joueur->list();
        }
        $stat = $request->getParam('stat');
        if ($stat=='listimpair'){
            return $this->joueur->listimpair();
        }
        $stat = $request->getParam('stat');
        if ($stat=='listpair'){
            return $this->joueur->listpair();
        }

        $id = $request->getId("id_joueur");
        if ($id){
            // URI is .../Joueur/{id_joueur}
            $j = $this->joueur->find($id);
            return $j == null ? false : $j;
        } else {
            return $this->joueur->findAll();
        }
    }
    

    protected function processPostRequest(HttpRequest $request) {
        $body = file_get_contents('php://input');
$data = json_decode($body, true);

if ($data === null) {
    throw new RuntimeException('Le corps de la requête est vide ou contient des données JSON invalides.');
}
        $id_perso = $data['id_perso'] ?? null;
        $nom = $data['nom'] ?? null;
        $ville = $data['ville'] ?? null;

        if ($id_perso && $nom && $ville) {
            return $this->joueur->save([
                'id_perso' => $id_perso,
                'nom' => $nom,
                'ville' => $ville
            ]);
        } else {
            return false;
        }
        
    }


    protected function processDeleteRequest(HttpRequest $request) {
        return $this->joueur->deleteAll();
    }

    
protected function processDeleteByIdRequest(HttpRequest $request) {
    $id = $request->getId("ville");
    if ($id) {
        return $this->joueur->deleteByville($id);
    } else {
        return false;
    }
}
}
?>
