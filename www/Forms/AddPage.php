<?php
namespace App\Forms;
class AddPage
{

    public function getConfig(): array
    {
        return [
            "config"=> [
                        "method"=>"POST",
                        "action"=>"new-page",
                        "submit"=>"Enregistrer",
                        "class"=>"form",
                        "id"=>"form-add"
                     ],
            "inputs"=> [
                "Titre"=>["type"=>"text", "class"=>"input-form art-title", "id"=>"title", "placeholder"=>"Titre", "minlen"=>2, "required"=>true, "error"=>"Le titre doit avoir au moins 2 caractères"],
                // "Contenu"=>["type"=>"text", "size"=>"50", "class"=>"input-form art-content","id"=>"content", "placeholder"=>"Contenu de l'article", "minlen"=>20, "required"=>true, "error"=>"Le contenu doit faire plus de 20 caractères"],
            ],
            "textareas"=>[
                "Contenu"=>["type"=>"textarea", "name"=>"description", "class"=>"input-form textarea-form", "id"=>"mytextarea", "placeholder"=>"Description", "minlen"=>2, "required"=>true, "rows"=>10],
            ]
        ];
    }

}
