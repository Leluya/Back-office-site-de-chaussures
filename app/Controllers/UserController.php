<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
use App\Models\AppUser;
use App\Models\CoreModel;

class UserController extends CoreController
{
    /**
     * Méthode s'occupant de lister les users
     *
     * @return void
     */
    public function list()
    {
        // on vérifie les autorisations
        $this->checkAuthorization(['admin']);

        // on instancie notre modèle Category
        //$categoryModel = new Category();
        // on récupère notre liste de catégories depuis le modèle
        $userList = AppUser::findAll();

        $this->show('user/list', [
            'userList' => $userList
        ]);
    }

    /**
     * Méthode qui affiche le formulaire d'ajout (ou de modification)
     *
     * @return void
     */
    public function show_form() {

        // on vérifie les autorisations
        $this->checkAuthorization(['admin']);

        $user = new AppUser();
        $editMode = false;

        $this->show('user/form', [
            'user' => $user,
            'editMode' => $editMode,
            'errorList' => []
        ]);
    }

    /**
     * Méthode pour réceptionner les données du formulaire de modification ou d'ajout et les insérer en DB
     *
     * @return void
     */
    public function create_or_update() {

        // on vérifie les autorisations
        $this->checkAuthorization(['admin']);

        // on créé un tableau vide pour stocker nos erreurs (potentielles)
        $errorList = [];

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // le filter_sanitize permet de "nettoyer" l'adresse mail (enlever les caractères incorrects et éviter la faille XSS)
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        // le filter_validate permet de vérifier si l'adresse email est "correcte" (est-ce qu'elle contient un @, un domaine correct après le @, etc.)
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        // on vérifie si l'email existe déjà
        $user = AppUser::findByEmail($email);
        // si $user n'est pas false, un user existe déjà avec cette adresse mail
        if($user) {
            $errorList[] = "L'email est déjà pris !";
            //exit;
        }

        $password = filter_input(INPUT_POST, 'password');
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        if($email === false) {
            $errorList[] = "L'email est incorrect !";
            //exit;
        }

        // validation : le mdp ne peut pas être vide
        if(empty($password)) {
            $errorList[] = "Le mot de passe ne peut pas être vide !";
        }
        // validation : le mdp doit faire 8 caractères mini.
        if(strlen($password) < 8) {
            $errorList[] = "Le mot de passe doit faire au moins 8 caractères !";
        }

        // validation : au moins un caractère en majuscule
        // if (strtolower($password) === $password) {
        //     $errorList[] = "Le mot de passe doit contenir au moins un caractère en majuscule !";
        // }

        // // validation : au moins un caractère en minuscule
        // if (strtoupper($password) === $password) {
        //     $errorList[] = "Le mot de passe doit contenir au moins un caractère en minuscule !";
        // }

        // validation : minuscules / majuscules : deuxième possibilité
        if(ctype_upper($password)) {
            $errorList[] = "Le mot de passe doit contenir au moins un caractère en minuscule !";
        }
        if(ctype_lower($password)) {
            $errorList[] = "Le mot de passe doit contenir au moins un caractère en majuscule !";
        }

        // validation : au moins un caractère est un chiffre
        if(ctype_alpha($password)) {
            $errorList[] = "Le mot de passe doit contenir au moins un chiffre !";
        }

        // validation : au moins un caractère est un chiffre
        if(ctype_alnum($password)) {
            $errorList[] = "Le mot de passe doit contenir au moins un caractère qui n'est pas un chiffre ou une lettre !";
        }

        // if(!preg_match("/^(?=.*[_@|$%&*=-])(?=.*[0-9])(?=.*[A-Z]).{8,}$/", $password)){
        //     $errorList[] = "Le mot de passe doit contenir au moins un chiffre, une majuscule, une minuscule, un caractère spécial, etc.";
        // }

        if(!is_null($email) && !is_null($password) && !is_null($role) && !is_null($status)) {
            
 
            // on instancie un nouvel objet AppUser
            $user = new AppUser();

            // on alimente notre objet avec les setters
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $user->setRole($role);
            $user->setStatus($status);

            // on peut insérer cet objet dans la BDD
            // si on a pas eu d'erreur jusque là !
            if(count($errorList) === 0) {
                if($user->save()) {
                    // save renvoie true, l'insertion s'est bien passée
                    //dump($category);
                    header('Location: http://localhost:8080/user/list');
                    exit;
                } else {
                    $errorList[] = "erreur lors de l'insertion en DB";
                }  
            }
        } else {
            $errorList[] = "erreur l'un des champs n'est pas défini";
        }

        if(count($errorList) > 0) {
            // on a au moins une erreur dans notre tableau
            // donc on affiche la vue avec les erreurs
            $this->show('user/form', [
                'user' => $user,
                'editMode' => false,
                'errorList' => $errorList
            ]);
        }
    } 
    
    // public function delete($categoryId) {
    //     // on récupère un objet Category existant (grace à son ID !)
    //     $category = Category::find($categoryId);

    //     if($category->delete()) {
    //         // save renvoie true, la suppression s'est bien passée
    //         header('Location: http://localhost:8080/category/list');
    //         exit;
    //     } else {
    //         print "erreur lors de la suppression de la DB";
    //     } 
    // }

}