<?php

namespace App\Controllers;

class CoreController
{
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }
    public function checkAuthorization($roles = []) {
        // est-ce qu'un user est connecté ?
        if(isset($_SESSION['userObject'])) {
            // $_SESSION['userObject'] est défini donc oui

            // on récupère l'user
            $user = $_SESSION['userObject'];

            // est-ce que le rôle de l'user est autorisé à accéder à cette page ?
            if(in_array($user->getRole(), $roles)) {
                // l'user a un rôle autorisé donc on retourne true
                return true;
            } else {
                // il n'a pas le droit d'accéder à la page
                // on retourne une erreur HTTP 403 Forbidden
                //header("HTTP/1.1 403 Forbidden");
                
                // version avec view err403
                $controller = new ErrorController();
                $controller->err403();

                // on arrête le script
                exit();
            }
        } else {
            // si l'user n'est pas connecté, on le redirige vers le formulaire
            header('Location: http://localhost:8080/login');
            exit();
        }     
    }
}
