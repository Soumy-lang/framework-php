<?php

namespace App\Forms;

class InstallSite
{
    public function getConfig(): array
    {
        return [
            "config"=> [
                "method"=>"POST",
                "action"=>"run",
                "submit"=>"Installer le site",
                "class"=>"form"
            ],
            "inputs"=>[
                "Prénom"=>["type"=>"text", "class"=>"input-form", "id"=>"firstname", "placeholder"=>"Prénom", "minlen"=>2, "required"=>true, "error"=>"Le prénom doit faire plus de 2 caractères" ],
                "Nom"=>["type"=>"text", "class"=>"input-form","id"=>"lastname", "placeholder"=>"Nom", "minlen"=>2, "required"=>true, "error"=>"Le nom doit faire plus de 2 caractères"],
                "Nom d'utilisateur"=>["type"=>"text", "class"=>"input-form","id"=>"username", "placeholder"=>"Nom d'utilisateur", "minlen"=>2, "required"=>true, "error"=>"Le nom doit faire plus de 2 caractères"],
                "E-mail"=>["type"=>"email", "class"=>"input-form","id"=>"email", "placeholder"=>"E-mail", "required"=>true, "error"=>"Le format de l'email est incorrect"],
                "Mot de passe"=>["type"=>"password", "class"=>"input-form","id"=>"pwd", "placeholder"=>"Mot de passe", "required"=>true, "error"=>"Votre mot de passe doit faire plus de 8 caractères avec minuscule et chiffre"],
                "Confirmation de mot de passe"=>["type"=>"password", "class"=>"input-form","id"=>"pwdConfirm", "confirm"=>"pwd" ,"placeholder"=>"Confirmation mdp", "required"=>true, "error"=>"Votre mot de passe de confirmation ne correspond pas"],

                "Prefixe des tables"=>[
                    "type"=>"text",
                    "name" => "table_prefix",
                    "class" => "input-form",
                    "placeholder" => "Préfixe pour les tables (ex: mysite_)",
                    "required"=>true,
                    "error"=>"Veuillez entrer un préfixe pour les tables de la base de données",

                ],
            ]
        ];
    }
}
