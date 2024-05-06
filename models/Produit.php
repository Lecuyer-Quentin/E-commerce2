<?php

class Produit
{
    private int $id;
    private string $nom;
    private float $prix;
    private bool $inStock;
    private Categorie $categorie;
    private string $date_ajout;

    // Optional
    private ?string $image;
    private ?string $description;
    private Special $special;




    public function __construct ($id, $nom, $prix, $inStock, $categorie, $date_ajout,
                                     $image = null, $description = null, $special = null)
    {
        $this->set_value_of('id', $id);
        $this->set_value_of('nom', $nom);
        $this->set_value_of('prix', $prix);
        $this->set_value_of('inStock', (bool)$inStock); // Convert to boolean (0 => false, 1 => true)
        $this->set_value_of('categorie', $categorie);
        $this->set_value_of('date_ajout', $date_ajout);
        $this->set_value_of('image', $image);
        $this->set_value_of('description', $description);
        $this->set_value_of('special', $special);

    }

    public function set_value_of($attribut, $valeur)
    {
        if(property_exists($this, $attribut) ){
            $this->$attribut = $valeur;
        }
    }

    public function get_value_of($attribut)
    {
        if(property_exists($this, $attribut)){
            if($attribut == 'image')
            {
                return 'images/products/' . $this->$attribut;
            }
            return $this->$attribut;
        }
    }

    public function __toString()
    {
        return $this->nom;
    }

}