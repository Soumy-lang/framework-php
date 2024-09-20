<?php
namespace App\Controllers;
use App\Core\View;
use App\Models\User;
use App\Models\Post;

require __DIR__ . '/../core/View.php';
require __DIR__ . '/../Models/User.php';
require __DIR__ . '/../Models/Post.php';

class Main
{
    public function home(): void
    {
        $user = new User();
        $post = new Post();

        $elementsCount = [
            'users' => $user->getNbElements(),
            'pages' => $post->getElementsByType('type', 'page'),
            'articles' => $post->getElementsByType('type', 'article'),
        ];

        // Initialiser les variables avec des valeurs par défaut
        $lastname = '';
        $firstname = '';
        $roles = [];

        if (isset($_SESSION['user'])) {
            $userSerialized = $_SESSION['user'];

            $user = unserialize($userSerialized);
            $lastname = $user->getLastname();
            $firstname = $user->getFirstname();
            $roles = $user->getRoles();
        }

        $myView = new View("Main/home", "back");
        $myView->assign("elementsCount", $elementsCount);
        $myView->assign("lastname", $lastname);
        $myView->assign("firstname", $firstname);
        $myView->assign("roles", $roles);
    }
}
