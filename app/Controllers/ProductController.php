<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
use App\Models\Product;
use PDO;

class ProductController extends CoreController
{
    /**
     * Méthode s'occupant de la page produit
     *
     * @return void
     */
    public function product()
    {
        $productObject = new Product();
        $arrayProduits = $productObject->findAll();

        $this->show('main/product', ['array_produits' => $arrayProduits]);
    }

     /**
     * Méthode s'occupant de la page d'ajout de produit
     *
     * @return void
     */
    public function product_add()
    {
        // On appelle la méthode productAdd() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/product_add');
    }
}