<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Brand;

class ProductController extends CoreController
{
    /**
     * Méthode s'occupant de lister les products
     *
     * @return void
     */
    public function list()
    {
        // on récupère notre liste de produits
        $productList = Product::findAll();

        $this->show('product/list', [
            'productList' => $productList
        ]);
    }

    /**
     * Méthode qui affiche le formulaire d'ajout ou de modification
     *
     * @return void
     */
    public function show_form($productId = null) {
        if(is_null($productId)) {
            $product = new Product();
            $editMode = false;
        } else {
            $product = Product::find($productId);
            $editMode = true;
        }

        $brands = Brand::findAll();

        $this->show('product/form', [
            'product' => $product,
            'brands' => $brands,
            'editMode' => $editMode
        ]);
    }

    /**
     * Méthode pour réceptionner les données du formulaire de modification ou d'ajout et les insérer en DB
     *
     * @return void
     */
    public function create_or_update($productId = null) {

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description');
        $picture = filter_input(INPUT_POST, 'picture');
        $price = filter_input(INPUT_POST, 'price');
        $rate = filter_input(INPUT_POST, 'rate');
        $status = filter_input(INPUT_POST, 'status');
        $brand_id = filter_input(INPUT_POST, 'brand_id');
        $type_id = filter_input(INPUT_POST, 'type_id');
        $category_id = filter_input(INPUT_POST, 'category_id');

        if(!is_null($name) && !is_null($description) && !is_null($picture) && !is_null($price) && !is_null($rate) && !is_null($status) && !is_null($brand_id) && !is_null($type_id) && !is_null($category_id)) {
            
            if(is_null($productId)) {
                // $productId est null, donc on est en train de créer un produit

                // on instancie un nouvel objet Produit
                $product = new Product();
            } else {
                // productId n'est pas null, on modifie un produit existant

                // on récupère un objet Product existant (grace à son ID !)
                $product = Product::find($productId);
            }

            // on alimente notre objet avec les setters
            $product->setName($name);
            $product->setDescription($description);
            $product->setPicture($picture);
            $product->setPrice($price);
            $product->setRate($rate);
            $product->setStatus($status);
            $product->setBrandId($brand_id);
            $product->setTypeId($type_id);
            $product->setCategoryId($category_id);
            

            //dump($category);

            // on peut insérer cet objet dans la BDD
            if($product->save()) {
                // insert renvoie true, l'insertion s'est bien passée
                //dump($product);
                header('Location: http://localhost:8080/product/list');
                exit;
            } else {
                print "erreur lors de l'insertion en DB";
            }    

        } else {
            print "erreur l'un des champs n'est pas défini";
        }
    } 

    public function delete($productId) {
        // on récupère un objet Product existant (grace à son ID !)
        $product = Product::find($productId);

        if($product->delete()) {
            // save renvoie true, la suppression s'est bien passée
            header('Location: http://localhost:8080/product/list');
            exit;
        } else {
            print "erreur lors de la suppression de la DB";
        } 
    }
}