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
        if ($stat == 'listall') {
            return $this->joueur->listall();
        }
        if ($stat == 'list') {
            return $this->joueur->list();
        }
        if ($stat == 'listimpair') {
            return $this->joueur->listimpair();
        }
        if ($stat == 'listpair') {
            return $this->joueur->listpair();
        }

        $id = $request->getId("id_joueur");
        if ($id) {
            // URI is .../Joueur/{id_joueur}
            $j = $this->joueur->find($id);
            return $j == null ? false : $j;
        } else {
            return $this->joueur->findAll();
        }
    }

    protected function processPostRequest(HttpRequest $request) {
        
        $data = json_decode(file_get_contents("php://input"), true);
        

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

    public function saveVille($request) {
        if ($request->getMethod() == "POST") {
            $data = $request->getBody(); // Récupérer les données de la requête
            if (isset($data['ville'])) {
                $_SESSION['ville'] = $data['ville']; // Sauvegarder dans la session
                return json_encode(['success' => true, 'message' => 'Ville sauvegardée.']);
            }
        }
        return json_encode(['success' => false, 'message' => 'Ville non spécifiée.']);
    }

    public function getVille() {
        if (isset($_SESSION['ville'])) {
            return json_encode(['success' => true, 'ville' => $_SESSION['ville']]);
        }
        return json_encode(['success' => false, 'message' => 'Aucune ville sauvegardée.']);
    }

    public function deleteVille() {
        if (isset($_SESSION['ville'])) {
            unset($_SESSION['ville']); // Supprime la ville de la session
            return json_encode(['success' => true, 'message' => 'Ville supprimée.']);
        }
        return json_encode(['success' => false, 'message' => 'Aucune ville à supprimer.']);
    }
}
?>
