<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class CatAddController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function categoryAdd()
    {
        // On appelle la méthode category() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/category_add');
    }
}