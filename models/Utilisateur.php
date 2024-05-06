<?php

class Utilisateur
{
    private int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $mot_de_passe;
    private Role $role;
    private string $date_inscription;
    private bool $isActif;
    private string $token;

    // Optionnel
    private ?string $numRue;
    private ?string $nomRue;
    private ?string $codePostal;
    private ?string $ville;
    private ?string $pays;
    private ?string $avatar;

    public function __construct ($id, $nom, $prenom, $email, $mot_de_passe, Role $role, $date_inscription, $isActif, $token, 
                                    $numRue=null, $nomRue=null, $ville=null, $codePostal=null, $pays=null, $avatar=null)
    {
        $this->set_value_of('id', $id);
        $this->set_value_of('nom', $nom);
        $this->set_value_of('prenom', $prenom);
        $this->set_value_of('email', $email);
        $this->set_value_of('mot_de_passe', $mot_de_passe);
        $this->set_value_of('role', $role);
        $this->set_value_of('date_inscription', $date_inscription);
        $this->set_value_of('isActif', (bool)$isActif);
        $this->set_value_of('token', $token);
        $this->set_value_of('numRue', $numRue);
        $this->set_value_of('nomRue', $nomRue);
        $this->set_value_of('ville', $ville);
        $this->set_value_of('codePostal', $codePostal);
        $this->set_value_of('pays', $pays);
        $this->set_value_of('avatar', $avatar);
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
            if($attribut == 'avatar'){
                return 'images/avatars/' . $this->$attribut;
            }
            return $this->$attribut;
        }
    }

    public function __toString()
    {
        return $this->nom . ' ' . $this->prenom;
    }
}