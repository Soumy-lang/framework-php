<?php namespace App\Controllers; ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Template Back</title>
        <link rel="stylesheet" type="text/css" href="/views/styles/dist/css/main.css">
        <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-g6R+2qH1I8hzl6fXExdSN3R/xkA6r0/KRXC5WAPtzIiq/T6NoD2efpZ/KisK/AJUp" crossorigin="anonymous">

        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <header id="header" class="back-office-header">
            <nav class="navbar">
                <div class="navbar_toggle_content" id="content">
                    <ul>
                        <li><a href="/bo/dashboard" class="pages-list">
                            <div class="pages-title">Tableau de bord</div></a>
                        </li>
                        <li><a href="/bo/posts" class="accordion">
                            <div class="pages-title">Pages</div></a>
                        </li>
                        <li><a href="/bo/articles" class="accordion">
                            <div class="pages-title">Articles</div></a>
                        </li>
                        <li><a href="/bo/user" class="accordion">
                            <div class="pages-title">Utilisateurs</div></a>
                        </li>
                        <li><a href="/bo/settings" class="accordion">
                            <div class="pages-title">Réglages</div></a>
                        </li>
                    </ul>
                </div>
                <div class="disconnect-button">
                    <form method="POST" action="/logout" style="display: inline;">
                        <button type="submit" name="logout" class="btn-logout">
                            <img src="/views/styles/assets/images/logout.svg" alt="Déconnexion" title="Déconnexion">
                        </button>
                    </form>
                </div>
            </nav>
        </header>
        <main class="back-office-content">
            <?php include $this->viewName;?>
        </main>
    </body>
</html>
