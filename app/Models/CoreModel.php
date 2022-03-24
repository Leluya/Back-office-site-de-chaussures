<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models

// une classe abstraite (définie avec abstract) ne PEUT PAS être instanciée
// on peut juste créer des classes qui vont en hériter
abstract class CoreModel
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
    public function save() {
        if(isset($this->id) && $this->id > 0) {
            // si l'ID est défini est > 0, ça veut dire qu'on est en train de modifier un model
            return $this->update();
        } else {
            // sinon on est en train de créer un nouveau model
            return $this->insert();
        }
    }

    // une méthode abstraite doit OBLIGATOIREMENT être implémentée dans les classes qui héritent de CoreModel
    abstract public function insert();
    abstract public function update();
    abstract public function delete();
}
