<?php

//il faut ajouter les pages d'erreur 404 et 403
namespace App;
use App\Controllers\Error;
use App\Controllers\Main;
use App\Controllers\Security;
use App\Models\User;
use App\Core\PageBuilder;

date_default_timezone_set('Europe/Paris');
spl_autoload_register("App\myAutoloader"); //pour enregistrer une fonction d'autoload personnalisée

// Traitement spécial pour la route d'installation
$uri = strtolower($_SERVER["REQUEST_URI"]); // Normalise l'URI
$uri = strtok($uri, "?"); // Enlève les paramètres GET
$uri = strlen($uri) > 1 ? rtrim($uri, "/") : $uri; // Nettoie l'URI


// Exclut la logique de routage pour /install si config.php n'existe pas
if (!file_exists('./config.php')) {
    $controller = new \App\Controllers\Install();
    $controller->run();
    die();
}

function myAutoloader(String $class): void
{
    //$class = App\Core\View
    $class = str_replace("App\\","", $class); //pour remplacer App\Core\View par Core\View
    //$class = Core\View
    $class = str_replace("\\","/", $class); //pour remplacer Core\View par Core/View
    //$class = Core/View
    if(file_exists($class.".php")){ //pour vérifier si le fichier existe
        include $class.".php"; //si oui, on l'inclut
    }
}



if(!file_exists("routes.yaml")){ //pour vérifier si le fichier routes existe
    die("Le fichier de routing n'existe pas");
}
$listOfRoutes = yaml_parse_file("routes.yaml"); //pour récupérer le contenu du fichier routes


if( !empty($listOfRoutes[$uri]) ) { // si l'uri existe dans le fichier routes


    if (isset($listOfRoutes[$uri]['security']) && $listOfRoutes[$uri]['security'] === true) {
        session_start();
        if (!isset($_SESSION['user'])) { // Vérifier si l'utilisateur est connecté
            require "Controllers/Error.php";
            $error = new Error();
            $error->page403();
            die();
        }
    }

    if (!empty($listOfRoutes[$uri]['roles'])) {
        $user = unserialize($_SESSION['user']); // Récupérer l'utilisateur de la session

        if (!in_array($user->getRoles(), $listOfRoutes[$uri]['roles'])) {
            require "Controllers/Error.php";
            $error = new Error();
            $error->page403();
            die();
        }
    }


    if (!empty($listOfRoutes[$uri]['controller'])) { // si l'uri contient un controller
        if (!empty($listOfRoutes[$uri]['action'])) { // si l'uri contient une action

            //on récupère le controller et l'action
            $controller = $listOfRoutes[$uri]['controller'];
            $action = $listOfRoutes[$uri]['action'];

            if (file_exists("Controllers/" . $controller . ".php")) { //si le fichier controller existe
                include_once "Controllers/" . $controller . ".php"; //on l'inclut
                $controller = "App\\Controllers\\" . $controller; //on ajoute le namespace
                if (class_exists($controller)) { //si la classe du controller existe
                    $objectController = new $controller(); //on instancie le controller

                    if (method_exists($objectController, $action)) { //si l'action existe dans le controller
                        $objectController->$action();
                    } else {
                        die("L'action n'existe pas dans le controller");
                    }

                } else {
                    die("La classe du controller n'existe pas");
                }

            } else {
                die("Le fichier controller n'existe pas");
            }

        } else {
            die("La route ne contient pas d'action");
        }
    } else {
        die("La route ne contient pas de controller");
    }
}
else if($uri){
        session_start();
        $pageBuilder = new PageBuilder();
        $pageBuilder->build($uri);
}
else{ //si l'uri n'existe pas dans le fichier routes
    require "Controllers/Error.php"; //page 404
    $customError = new Error();
    $customError->page404();
}
