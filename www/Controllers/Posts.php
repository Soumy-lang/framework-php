<?php

namespace App\Controllers;

use App\Core\DB;
use App\Core\View;
use App\Core\PageBuilder;
use App\Models\Post;
use App\Models\Theme;
use App\Models\Media;
use App\Models\User;
use App\Forms\AddArticle;
use App\Forms\UpdateArticle;

class Posts
{
    public function allPages(): void
    {

        $post = new Post();
        $posts = $post->getAllData("object");

        $allPostView = new View("Post/post", "back");
        $allPostView->assign("posts", $posts);
    }

    public function newPage(): void
    {
        $newPost = new View("Post/newpost", "back");
    }

    public function allArticles(): void
    {

        $errors = [];
        $success = [];
        $article = new Post();
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $articleId = $_GET['id'];

            if ($_GET['action'] === 'delete') {
                if ($article->delete(['id' => $articleId])) {
                    $success[] = "L'article a été supprimé avec succès.";
                } else {
                    $errors[] = "La suppression a échoué.";
                }
            } elseif ($_GET['action'] === 'draft') {
                if ($article->drafts(['id' => $articleId])) {
                    $success[] = "L'article a été restauré avec succès";
                } else {
                    $errors[] = "Echoué";
                }
            } elseif ($_GET['action'] === 'publish') {
                if ($article->publish(['id' => $articleId])) {
                    $success[] = "L'article a été publié avec succès";
                } else {
                    $errors[] = "Echoué";
                }
            }
        }

        $allArticles = $article->getAllArticles();
        // $publishArticles = $article->getPublishedPost();
        $draftArticles = $article->getDraft();

        $myView = new View("Articles/allArticles", "back");
        $myView->assign("articles", $allArticles);
        // $myView->assign("publishArticles", $publishArticles);
        $myView->assign("draftArticles", $draftArticles);
        $myView->assign("errors", $errors);
        $myView->assign("success", $success);
    }

    public function newArticle(): void
    {
        // if( $_SERVER["REQUEST_METHOD"] == $config["config"]["method"] )
        // {
            $currentDate = date('Y-m-d H:i:s');
            $article = new Post();

            $article->setSlug(""); // Le slug de l'article
            $article->setTitle($_REQUEST['Titre']); // Le titre de l'article
            $article->setBody($_REQUEST['Contenu']); // Le contenu de l'article
            $article->setPublished(1); // 1 pour publié, 0 pour brouillon
            $article->setIsdeleted(0); // Non supprimé par défaut
            $article->setCreatedat($currentDate); // Date de créationdon
            $article->setType("article"); // Type d'article
            $article->setUserUsername(""); // Nom d'utilisateur de l'auteur

            $article->save(); //ajouter toutes les données dans la base de données
            $success[] = "Ajouté";
            header("Location: /bo/articles");

        // }  
        
    }

    public function editArticle(): void
    {

        $article = new Post();
        if (isset($_GET['article']) && $_GET['article']) {
            $articleId = $_GET['article'];
            $selectedArticle = $article->getOneBy(['id' => $articleId]);

            if ($selectedArticle) {
                $formUpdate = new UpdateArticle();
                $configUpdate = $formUpdate->getConfig($selectedArticle["title"], $selectedArticle["body"], $selectedArticle["id"]);
                $errorsUpdate = [];
                $successUpdate = [];

                $myView = new View("Articles/editArticles", "back");
                $myView->assign("article", $selectedArticle);
                $myView->assign("configForm", $configUpdate);
                $myView->assign("errorsForm", $errorsUpdate);
                $myView->assign("successForm", $successUpdate);
            } else {
                echo "Article non trouvé.";
            }
        }
    }

    public function addArticles(): void
    {
        $form = new AddArticle();
        $config = $form->getConfig();
        $myView = new View("Articles/addArticles", "back");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", []);
        $myView->assign("successForm", []);

    }

    public function updateArticle(): void
    {
        $userSerialized = $_SESSION['user'];
        $user = unserialize($userSerialized);
        $username = $user->getUsername();

        $formattedDate = date('Y-m-d H:i:s');

        $title = $_REQUEST['Titre'];
        $body = $_REQUEST['Contenu'];

        $article = new Post();
        $article->setTitle($title);
        $article->setBody($body);

        if($_GET['id']){
            $post = new Post();
            $articleId = $_GET['id'];
            $selectedArticle = $post->getOneBy(['id' => $articleId]);

            $article->setId($_GET['id']);
            $article->setUpdatedAt($formattedDate);
            $article->setCreatedAt($selectedArticle["createdat"]);
            $article->setIsDeleted($selectedArticle["isdeleted"]);
            $article->setPublished($selectedArticle["published"]);
            $article->setSlug($selectedArticle["slug"]);
            $article->setType($selectedArticle["type"]);
            $article->setUserId($selectedArticle["user_username"]);


        }else{
            $article->setUpdatedAt($formattedDate);
            $article->setCreatedAt($formattedDate);

            $article->setIsDeleted(0);
            $article->setPublished(1);
            $article->setSlug("");
            $article->setType("article");
            $article->setUserId($username);

        }

        $article->save();
        header("Location: /bo/articles");
        exit();
    }

}
