<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class AppUser extends CoreModel
{
    // Les propriétés représentent les champs
    // Attention il faut que les propriétés aient le même nom (précisément) que les colonnes de la table

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $role;

    /**
     * @var int
     */
    private $status;

    /**
     * Get the value of password
     *
     * @return  string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the value of role
     *
     * @return  string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function insert() {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // on prépare la requete
        $stmt = $pdo->prepare("
             INSERT INTO `app_user` (email, password, firstname, lastname, role, status)
             VALUES (:email, :password, :firstname, :lastname, :role, :status)
        ");

        // on va associer nos variables
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':status', $this->status);

        // on lance la req
        if ($stmt->execute()) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    public function update() {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // on prépare la requete
        $stmt = $pdo->prepare("
                UPDATE `app_user`
                SET
                    email = :email,
                    password = :password,
                    firstname = :firstname,
                    lastname = :lastname,
                    role = :role,
                    status = :status,
                    updated_at = NOW()
                WHERE id = :id
            ");

        // on va associer nos variables
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':status', $this->status);

        // on execute et on retourne le résultat (true si ok, false si nok)
        return $stmt->execute();
    }

    public function delete() {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // on prépare la requete
       $stmt = $pdo->prepare("
            DELETE FROM `app_user`
            WHERE id = :id
        ");

        // on va associer nos variables
        $stmt->bindParam(':id', $this->id);

        // on execute et on retourne le résultat (true si ok, false si nok)
        return $stmt->execute();
    }

    /**
     * 
     *  Cette méthode permet de venir récupérer (depuis la DB) un objet AppUser
     *  en fonction de son email ! 
     *  @return AppUser
     */
    public static function findByEmail($email) {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $stmt = $pdo->prepare("SELECT * FROM `app_user` WHERE `email` = :email");

        // on va associer nos variables
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            
            // un seul résultat => fetchObject
            $user = $stmt->fetchObject('App\Models\AppUser');

            return $user;
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Méthode statique permettant de récupérer tous les enregistrements de la table app_user
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');

        return $results;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     *
     * @return  self
     */ 
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     *
     * @return  self
     */ 
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Set the value of role
     *
     * @param  string  $role
     *
     * @return  self
     */ 
    public function setRole(string $role)
    {
        $this->role = $role;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     *
     * @return  self
     */ 
    public function setStatus(int $status)
    {
        $this->status = $status;
    }
}