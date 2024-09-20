<?php

namespace App\Controllers;

use App\Forms\InstallSite;
use App\Core\View;
use App\Core\Verificator;
use App\Models\User;
use PDO;
use PDOException;
use App\Controllers\Security;
class Install
{
    public function run()
    {

        $form = new InstallSite();
        $config = $form->getConfig();
        $errors = [];
        $success = [];

        if ($_SERVER["REQUEST_METHOD"] === $config["config"]["method"]) { // Si le formulaire est soumis

            $verificator = new Verificator(); 
            if ($verificator->checkForm($config, $_REQUEST, $errors)) { 

                $adminFirstname = $_REQUEST['Prénom'] ?? ''; 
                $adminLastname = $_REQUEST['Nom'] ?? ''; 
                $adminEmail = $_REQUEST['E-mail'] ?? ''; 
                $adminUsername = $_REQUEST['Nom_d\'utilisateur'] ?? ''; 
                $adminPassword = $_REQUEST['Mot_de_passe'] ?? ''; 
                $adminPasswordConfirm = $_REQUEST['Confirmation_de_mot_de_passe'] ?? ''; 

                $dbhost= 'sg426040-001.eu.clouddb.ovh.net';
                $dbname = 'olympic'; 
                $dbuser = 'gamer'; 
                $dbpassword = 'OlympicGamers2024'; 
                $tablePrefix = $adminUsername . '_' . $_REQUEST['Prefixe_des_tables'] ?? '';   

                // Ecrire dans le fichier de configuration
                $myfile = fopen("config-local.php", "a");
                fwrite($myfile, "define('TABLE_PREFIX', '" . addslashes($tablePrefix) . "');\n");
                fclose($myfile);

                try {
                    $pdo = new \PDO("mysql:host=$dbhost;port=35340;dbname=$dbname;user=$dbuser;password=$dbpassword");

                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $bddPath = './BDD.sql';
                    if (file_exists($bddPath)) {
                        echo "Fichier trouvé";
                    } else {
                        echo "Fichier non trouvé";
                    }

                    $sqlScript = file_get_contents($bddPath);

                    $sqlScript = str_replace("{prefix}", $tablePrefix, $sqlScript);

                    $sqlStatements = explode(";", $sqlScript); // Séparer chaque instruction SQL

                    // Exécuter chaque instruction SQL
                    foreach ($sqlStatements as $statement) {
                        $trimmedStatement = trim($statement);
                        if ($trimmedStatement) {
                            $stmt = $pdo->prepare($trimmedStatement);
                            $stmt->execute();
                        }
                    }


                } catch (PDOException $e) {
                    var_dump('Erreur lors de l\'exécution du script SQL ou de la connexion à la base de données : ' . $e->getMessage());
                }
                
                $user = new User();
                $user->setFirstname($adminFirstname);
                $user->setLastname($adminLastname);
                $user->setUsername($adminUsername);
                $user->setEmail($adminEmail);
                $user->setPwd($adminPassword);
                $user->setRoles("admin");
                $user->setIsActive(true);
                $user->save(); //ajouter toutes les données dans la base de données
                $success[] = "Votre compte a bien été créé";

            }
            
            header("Location: /login");
        }
        $myView = new View("install");
        $myView->assign("configForm", $config);
        // Pas d'erreurs ou succès initiaux pour l'installation
        $myView->assign("errorsForm", $errors);
        $myView->assign("successForm", $success);

    }

    public function check()
    {
        echo "Installation de l'application";
    }


}
