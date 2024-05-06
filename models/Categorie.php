<?php

class Categorie 
{
    private int $id;
    private string $nom;

    public function __construct(int $id, string $nom) {
        $this->set_value_of('id', $id);
        $this->set_value_of('nom', $nom);
    }

    public function set_value_of($attribut, $valeur) {
        if(property_exists($this, $attribut) ){
            $this->$attribut = $valeur;
        }
    }
    public function get_value_of($attribut) {
        if(property_exists($this, $attribut)){
            return $this->$attribut;
        }
    }

    public function __toString() {
        return $this->nom;
    }
}