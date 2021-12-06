<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        $productObject = new Product();
        $arrayProduits = $productObject->findAll();
        
        $categoryObject = new Category();
        $arrayCategories = $categoryObject->findAll();
        
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/home', ['array_produits' => $arrayProduits],['array_categories' => $arrayCategories]);
    }
}
