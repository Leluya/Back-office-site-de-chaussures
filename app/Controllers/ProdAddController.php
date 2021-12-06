<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class ProdAddController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function productAdd()
    {
        // On appelle la méthode category() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/product_add');
    }
}   