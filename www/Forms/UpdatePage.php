<?php

namespace App\Forms;

class UpdatePage
{
    public function getConfig($defaultTitle, $defaultBody, $id): array
    {
        return [
            "config"=> [
                "method"=>"POST",
                "action"=>"update-page?id=" . urlencode(htmlspecialchars($id)),
                "submit"=>"Enregistrer",
                "class"=>"form",
                "id"=>"form-update"
            ],
            "inputs"=> [
                "Titre"=>["type"=>"text", "name"=>"title", "class"=>"input-form", "id"=>"title-article", "placeholder"=>"Titre", "minlen"=>2, "required"=>true, "value" => htmlspecialchars($defaultTitle)],
            ],
            "textareas"=>[
                "Contenu"=>["type"=>"textarea", "name"=>"description", "class"=>"input-form textarea-form", "id"=>"mytextarea", "placeholder"=>"Description", "minlen"=>2, "required"=>true, "rows"=>10, "value" => htmlspecialchars($defaultBody)],
            ]
        ];
    }
}