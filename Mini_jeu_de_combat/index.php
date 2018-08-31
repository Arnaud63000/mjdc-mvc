<?php

require 'libs/SuperPDO.php';
require 'app/managers/PersonnagesManager.php';
require 'app/models/Personnage.php';
require 'app/controllers/PersonnageController.php';

session_start();

/*
 * Démarrage de l'application. On y instancie toutes les
 * classes nécessaires.
 */
$pdo = new PDO('mysql:host=localhost;dbname=Combat', 'root', '');
$superPdo = new SuperPDO($pdo);

$manager = new PersonnagesManager($superPdo);

$controller = new PersonnageController($manager);


/*
 * Définition des routes qui définissent
 * les chemins possibles de l'application
 */
if (isset($_GET['deconnexion'])) {
    $controller->deconnexion();
}
else if (isset($_POST['creer']) && $controller->verifierPost('nom')) {
    $data = $controller->creer();
    $view = "selection-combat.php";
}
else if (isset($_POST['utiliser'])) {
    $data = $controller->utiliser();
    $view = "selection-combat.php";
}
else if (isset($_GET['frapper'])) {
    $data = $controller->frapper();
    $view = "selection-combat.php";
}
else {
    $view = "home.php";
}

/*
 * Affichage final de la view. Seulement
 * Si la variable $view a été définie par
 * une des routes.
 */
if (isset($view)) {
    // Export des variables créées dans le controller
    if (isset($data)) {
        extract($data);
    }

    // Capture du contenu qui sera inclus dans le layout
    // https://stackoverflow.com/questions/171318/how-do-i-capture-php-output-into-a-variable
    ob_start();
    require("./views/" . $view);
    $content = ob_get_clean();

    // Affichage du layout
    require("./views/layout.php");
}