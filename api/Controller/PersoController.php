<?php
require_once "Controller.php";
require_once "Repository/PersoRepository.php";

// This class inherits the jsonResponse method and the $cnx property from the parent class Controller
// Only the process????Request methods need to be (re)defined.

class PersoController extends Controller {

    private PersoRepository $perso;

    public function __construct(){
        $this->perso = new PersoRepository();
    }

    protected function processGetRequest(HttpRequest $request) {

        $stat = $request->getParam('stat');
        if ($stat=='list'){
            return $this->perso->list();
        }

        $id = $request->getId("id");
        if ($id){
            // URI is .../Perso/{id}
            $p = $this->perso->find($id);
            return $p == null ? false : $p;
        } else {
            return $this->perso->findAll();
        }
    }
    

    protected function processPostRequest(HttpRequest $request) {
        return false;
    }
}
?>
