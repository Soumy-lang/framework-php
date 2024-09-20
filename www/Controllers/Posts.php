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
use App\Forms\AddPage;
use App\Forms\UpdatePage;

class Posts
{

    public function allPages(): void
    {
        $post = new Post();
        $posts = $post->getAllData("object", "type", "page");
        $allPostView = new View("Post/post", "back");
        $allPostView->assign("posts", $posts);
    }

    public function newPage(): void
    {
        $userSerialized = $_SESSION['user'];
        $user = unserialize($userSerialized);
        $username = $user->getUsername();

        $currentDate = date('Y-m-d H:i:s');
        $page = new Post();

        $page->setSlug(""); 
        $page->setTitle($_REQUEST['Titre']);
        $page->setBody($_REQUEST['Contenu']); 
        $page->setPublished(1); 
        $page->setIsdeleted(0); 
        $page->setCreatedat($currentDate); 
        $page->setType("page");
        $page->setUserId($username);

        $page->save(); 
        $success[] = "Ajouté";
        header("Location: /bo/pages");
    }

    public function addPage(): void
    {
        $form = new AddPage();
        $config = $form->getConfig();
        $myView = new View("Post/newpost", "back");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", []);
        $myView->assign("successForm", []);

    }

    public function editPage(): void
    {

        $page = new Post();
        if (isset($_GET['page']) && $_GET['page']) {
            $pageId = $_GET['page'];
            $selectedPage = $page->getOneBy(['id' => $pageId]);

            if ($selectedPage) {
                $formUpdate = new UpdatePage();
                $configUpdate = $formUpdate->getConfig($selectedPage["title"], $selectedPage["body"], $selectedPage["id"]);
                $errorsUpdate = [];
                $successUpdate = [];

                $myView = new View("Post/editpage", "back");
                $myView->assign("page", $selectedPage);
                $myView->assign("configForm", $configUpdate);
                $myView->assign("errorsForm", $errorsUpdate);
                $myView->assign("successForm", $successUpdate);
            } else {
                echo "Non trouvé.";
            }
        }
    }

    public function deletePage(): void
    {
        $page = new Post();
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $pageId = $_GET['id'];
            if ($_GET['action'] === 'delete') {
                if ($page->delete(['id' => $pageId])) {
                    $success[] = "La page a été supprimé avec succès.";
                } else {
                    $errors[] = "La suppression a échoué.";
                }
            }
        }
        header("Location: /bo/pages");
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

        $allArticles = $article->getAllData("array", "type", "article");
        $draftArticles = $article->getDraft();

        $myView = new View("Articles/allArticles", "back");
        $myView->assign("articles", $allArticles);
        $myView->assign("draftArticles", $draftArticles);
        $myView->assign("errors", $errors);
        $myView->assign("success", $success);
    }

    public function newArticle(): void
    {
        $userSerialized = $_SESSION['user'];
        $user = unserialize($userSerialized);
        $username = $user->getUsername();

        $currentDate = date('Y-m-d H:i:s');
        $article = new Post();

        $article->setSlug(""); 
        $article->setTitle($_REQUEST['Titre']); 
        $article->setBody($_REQUEST['Contenu']); 
        $article->setPublished(1); 
        $article->setIsdeleted(0);
        $article->setCreatedat($currentDate); 
        $article->setType("article"); 
        $article->setUserId($username);

        $article->save();
        $success[] = "Ajouté";
        header("Location: /bo/articles");
        
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
