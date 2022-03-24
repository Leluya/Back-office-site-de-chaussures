<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
use App\Models\Category;
use App\Models\CoreModel;

class CategoryController extends CoreController
{
    /**
     * Méthode s'occupant de lister les categories
     *
     * @return void
     */
    public function list()
    {
        // on vérifie les autorisations
        $this->checkAuthorization(['admin', 'catalog-manager']);

        // on instancie notre modèle Category
        //$categoryModel = new Category();
        // on récupère notre liste de catégories depuis le modèle
        $categoryList = Category::findAll();

        $this->show('category/list', [
            'categoryList' => $categoryList
        ]);
    }

    /**
     * Méthode qui affiche le formulaire d'ajout ou de modification
     *
     * @return void
     */
    public function show_form($categoryId = null) {
        if(is_null($categoryId)) {
            $category = new Category();
            $editMode = false;
        } else {
            $category = Category::find($categoryId);
            $editMode = true;
        }

        $this->show('category/form', [
            'category' => $category,
            'editMode' => $editMode
        ]);
    }

    /**
     * Méthode pour réceptionner les données du formulaire de modification ou d'ajout et les insérer en DB
     *
     * @return void
     */
    public function create_or_update($categoryId = null) {

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');

        if(!is_null($name) && !is_null($subtitle) && !is_null($picture)) {
            
            if(is_null($categoryId)) {
                // $categoryId est null, donc on est en train de créer une catégorie

                // on instancie un nouvel objet Category
                $category = new Category();
            } else {
                // categoryId n'est pas null, on modifie une catégorie existante

                // on récupère un objet Category existant (grace à son ID !)
                $category = Category::find($categoryId);
            }
            
            // on alimente notre objet avec les setters
            $category->setSubtitle($subtitle);
            $category->setName($name);
            $category->setPicture($picture);

            // on peut insérer cet objet dans la BDD
            if($category->save()) {
                // save renvoie true, l'insertion s'est bien passée
                //dump($category);
                header('Location: http://localhost:8080/category/list');
                exit;
            } else {
                print "erreur lors de l'insertion en DB";
            }    

        } else {
            print "erreur l'un des champs n'est pas défini";
        }
    } 
    
    public function delete($categoryId) {
        // on récupère un objet Category existant (grace à son ID !)
        $category = Category::find($categoryId);

        if($category->delete()) {
            // save renvoie true, la suppression s'est bien passée
            header('Location: http://localhost:8080/category/list');
            exit;
        } else {
            print "erreur lors de la suppression de la DB";
        } 
    }

}