<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
use App\Models\Category;
use PDO;

class CategoryController extends CoreController
{
    /**
     * Méthode s'occupant de la page catégorie
     *
     * @return void$
     */
    public function category()
    {
        $categoryObject = new Category();
        $arrayCategories = $categoryObject->findAll();

        // dump($arrayCategories);
        $this->show('main/categories', [
            'array_categories' => $arrayCategories
        ]);
    }

    /**
     * Méthode s'occupant de la page d'ajout de catégorie
     *
     * @return void
     */
    public function category_add()
    {
        // On appelle la méthode category() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/category_add');
    }
}