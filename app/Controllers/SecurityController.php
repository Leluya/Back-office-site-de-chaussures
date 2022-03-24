<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Models\CoreModel;

class SecurityController extends CoreController
{
    /**
     * Méthode qui affiche le formulaire de connexion
     *
     * @return void
     */
    public function showLoginForm() {
        $this->show('security/login');
    }

    /**
     * Méthode pour réceptionner les données du formulaire de connexion
     *
     * @return void
     */
    public function login() {

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // tableau d'erreurs
        $errorList = [];
        $confirmList = [];

        if(!is_null($email) && !is_null($password)) {
            
            // récupérer l'user par son email
            $user = AppUser::findByEmail($email);

            // on test que findByEmail a renvoyé un user correct
            if($user) {
                // on vérifie que son MDP est correct
                if(password_verify($password, $user->getPassword())) {
                    // le mot de passe correspond à celui de l'user stocké en DB
                    $confirmList[] = "Bienvenue " . $user->getFirstname() . ' ' . $user->getLastname() . ' !';

                    // on stocke les infos de l'user en session
                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['userObject'] = $user;

                } else {
                    $errorList[] = "Email ou mot de passe incorrect.";
                }
            } else {
                $errorList[] = "Email ou mot de passe incorrect.";
            }

        } else {
            $errorList[] = "Erreur l'un des champs n'est pas défini";
        }

        $this->show('security/login', [
            'errorList' => $errorList,
            'confirmList' => $confirmList 
        ]);
    } 
    
    /**
     * Méthode pour se déconnecter
     *
     * @return void
     */
    public function logout() {
        // soit on détruit complétement la session
        session_destroy();

        // on unset les différentes variables de session
        //unset($_SESSION['userId']);
        //unset($_SESSION['userObject']);

        // on affiche la vue de confirmation
        $this->show('security/logout');
    } 

}