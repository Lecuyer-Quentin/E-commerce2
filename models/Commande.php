<?php

class Commande 
{
    private int $id;
    private string $date;
    private float $total;
    private Utilisateur $utilisateurs;
    private Produit $produits;


    public function __construct($id, $date, $utilisateurs, $produits){
        $this->set_value_of('id', $id);
        $this->set_value_of('date', $date);
        $this->set_value_of('total', $this->calculer_total());
        $this->set_value_of('utilisateurs', $utilisateurs);
        $this->set_value_of('produits', $produits);
    }

    private function calculer_total() {
        $total = 0;
        foreach($this->produits as $produit) {
            $total += $produit['prix'];
        }
        return $total;
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
        return 'Commande n°' . $this->id . ' du ' . $this->date . ' pour un total de ' . $this->total . '€';
    }
}