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
        // on récupère les catégories & les produits
        $categoryList = Category::findFirstThree();
        $productList = Product::findAll();
        
        $this->show('main/home', [
            'categoryList' => $categoryList,
            'productList' => $productList
        ]);
    }
}
