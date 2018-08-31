<?php 

class PersonnageController
{
    private $manager;

    public function __construct(PersonnagesManager $manager)
    {
        $this->manager = $manager;

        if(isset($_POST['nom'])) {
            $_SESSION["nom"] = $_POST['nom'];
        }
    }
    public function deconnexion()
    {
        session_destroy();
        $this->rediriger([
            "confirmation" => 'Vous êtes déconnecté.'
        ]);
    }

    public function creer()
    {
        $perso = new Personnage(['nom' => $_SESSION['nom']]);

        if (!$perso->nomValide()) {
            $this->rediriger([
                "erreur" => 'Le nom choisi est invalide.'
            ]);
        }
        elseif ($this->manager->exists($perso->nom)) {
            $this->rediriger([
                "erreur" => 'Le nom du personnage est déjà pris.'
            ]);
        }
        else {
            $this->manager->add($perso);
        }

        return $this->utiliser();
    }

    public function utiliser()
    {
        if ($this->manager->exists($_SESSION['nom'])) {
            $perso = $this->manager->get($_SESSION['nom']);
        }
        else {
            $this->rediriger([
                "erreur" => 'Ce personnage n\'existe pas !'
            ]);
        }

        $ennemis = $this->manager->getList($perso->nom);
        if (empty($ennemis)) {
            $_SESSION["erreur"] = 'Personne à frapper!';
        }

        return compact('perso', 'ennemis');
    }

    public function frapper()
    {
        $perso = $this->manager->get($_SESSION['nom']);

        if (!$this->manager->exists((int) $_GET['frapper'])) {
            $this->rediriger([
                "erreur" => 'Le personnage que vous voulez frapper n\'existe pas!'
            ]);
        }
        else {

            $persoAFrapper = $this->manager->get((int) $_GET['frapper']);
            $retour = $perso->frapper($persoAFrapper);

            switch ($retour) {
                case Personnage::CEST_MOI:
                    $_SESSION["erreur"] = 'Mais... pourquoi voulez-vous vous frapper ???';
                    break;
                case Personnage::PERSONNAGE_FRAPPE:
                    $perso->gagnerExperience();

                    $this->manager->update($perso);
                    $this->manager->update($persoAFrapper);

                    $_SESSION["confirmation"] = 'Le personnage a bien été frappé !';

                    break;
                case Personnage::PERSONNAGE_TUE;
                    $perso->gagnerExperience();

                    $this->manager->update($perso);
                    $this->manager->delete($persoAFrapper);

                    $_SESSION["confirmation"] = 'Vous avez tué ce personnage !';

                    break;
            }
        }

        return $this->utiliser();
    }

    public function verifierPost($key)
    {
        // Vérification de l'existence de la donnée dans le tableau POST
        // On déclenche une erreur fatale en cas de valeur vide.
        if(!isset($_POST[$key]) || !$_POST[$key]) {
            throw new \http\Exception\UnexpectedValueException(
                "La variable POST ne contient pas de valeur pour ".$key
            );
        }

        // Par défaut on return true car si on arrive ici,
        // c'est qu'aucune erreur n'a été déclenchée !
        return true;
    }

    public function rediriger($messages = [])
    {
        foreach($messages as $key => $message) {
            $_SESSION[$key] = $message;
        }
        header('Location: .');
        exit;
    }
}