<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\DB;
use App\Forms\AddArticle;
use App\Models\Article;
use App\Models\Post;

class Articles
{
    public function allArticles(): void
    {

        $errors = [];
        $success = [];
        $article = new Post();
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $articleId = $_GET['id'];

            if ($_GET['action'] === 'delete') {
                if ($article->delete($articleId)) {
                    $success[] = "L'article a été supprimé avec succès.";
                } else {
                    $errors[] = "La suppression a échoué.";
                }
            } elseif ($_GET['action'] === 'draft') {
                if ($article->drafts($articleId)) {
                    $success[] = "L'article a été restauré avec succès";
                } else {
                    $errors[] = "Echoué";
                }
            } elseif ($_GET['action'] === 'publish') {
                if ($article->publish($articleId)) {
                    $success[] = "L'article a été publié avec succès";
                } else {
                    $errors[] = "Echoué";
                }
            }
        }

        $allArticles = $article->getAllArticles();
        // $publishArticles = $article->getPublished();
        // $draftArticles = $article->getDraft();

        $myView = new View("Articles/allArticles", "back");
        $myView->assign("articles", $allArticles);
        // $myView->assign("publishArticles", $publishArticles);
        // $myView->assign("draftArticles", $draftArticles);
        $myView->assign("errors", $errors);
        $myView->assign("success", $success);
    }

    

    // public function newArticle(): void
    // {
    //     if( $_SERVER["REQUEST_METHOD"] == $config["config"]["method"] )
    //     {
    //         $article = new Post();

    //         $article->setSlug(""); // Le slug de l'article
    //         $article->setTitle($_REQUEST['title']); // Le titre de l'article
    //         $article->setBody($_REQUEST['body']); // Le contenu de l'article
    //         $article->setPublished(0); // 1 pour publié, 0 pour brouillon
    //         $article->setIsdeleted(0); // Non supprimé par défaut
    //         $article->setCreatedat(date('d-m-Y H:i:s')); // Date de création
    //         $article->setType("article"); // Type d'article
    //         $article->setThemeId(""); // ID du thème
    //         $article->setUserUsername(""); // Nom d'utilisateur de l'auteur

    //         $article->save(); //ajouter toutes les données dans la base de données
    //         $success[] = "Ajouté";
    //         header("Location: /bo/articles");

    //     }  
        
    // }

    // public function addArticles(): void
    // {
    //     $form = new AddArticle();
    //     $config = $form->getConfig();
    //     $myView = new View("Articles/addArticles", "back");
    //     $myView->assign("configForm", $config);
    //     $myView->assign("errorsForm", []);
    //     $myView->assign("successForm", []);

    // }

    
}

