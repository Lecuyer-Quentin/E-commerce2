<?php
require_once 'Produit.php';
require_once 'Categorie.php';
require_once 'Special.php';

class ProduitRepo

{
    private PDO $pdo;
    private string $table = 'produit';

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // SQL queries
    private function query_select(){
        $query = 'SELECT p.*, c.nom as categorie, c.id as categorie_id, s.nom as special, s.id as special_id FROM ' . $this->table . ' p';
        $query .= ' JOIN produit_categorie pc ON pc.fkIdProduit = p.id';
        $query .= ' JOIN categorie c ON c.id = pc.fkIdCategorie';
        $query .= ' JOIN produit_special ps ON ps.fkIdProduit = p.id';
        $query .= ' JOIN special s ON s.id = ps.fkIdSpecial';
        return $query;
    } 
    private function query_insert(){
        $query = 'INSERT INTO ' . $this->table . ' (nom, description, prix, inStock, date_ajout, image) VALUES (:nom, :description, :prix, :inStock, :date_ajout, :image)';
        return $query;
    }
    private function query_update(){
        $query = 'UPDATE ' . $this->table . ' ';
        $query .= 'SET nom = :nom, description = :description, prix = :prix, inStock = :inStock, date_ajout = :date_ajout, image = :image ';
        $query .= 'WHERE id = :id';
        return $query;
    }  
    // ----------- \\

    // Private methods \\
    private function prepare_data(array $data){
        $data = [
            'nom' => htmlspecialchars(strip_tags($data['nom'])),
            'description' => htmlspecialchars(strip_tags($data['description'])),
            'prix' => htmlspecialchars(strip_tags($data['prix'])),
            'inStock' => intval(htmlspecialchars(strip_tags($data['inStock']))),
            'image' => htmlspecialchars(strip_tags($data['image'])),
            'categorie' => $data['categorie'],
            'special' => $data['special'],
        ];
        return $data;
    }

    private function check_optional_data(array $row){
        if(!array_key_exists('image', $row)){
            $row['image'] = null;
        }
        if(!array_key_exists('special_id', $row)){
            $row['special_id'] = null;
        }
        if(!array_key_exists('special', $row)){
            $row['special'] = null;
        }
        if(!array_key_exists('description', $row)){
            $row['description'] = null;
        }
    }

    public function read_all()
    {
        $stmt = $this->pdo->prepare($this->query_select());
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $produits = [];
            foreach ($result as $row) {
                // Vérifier si les attributs existent avant de les utiliser
                $image = isset($row['image']) ? $row['image'] : null;
                $special = isset($row['special_id']) && isset($row['special']) ? new Special($row['special_id'], $row['special']) : null;
                $description = isset($row['description']) ? $row['description'] : null;
                $produit = new Produit(
                    $row['id'],
                    $row['nom'],
                    $row['prix'],
                    $row['inStock'],
                    new Categorie($row['categorie_id'], $row['categorie']),
                    $row['date_ajout'],
                    $image,
                    $description,
                    $special
                );
                array_push($produits, $produit);
            }
            $stmt->closeCursor();
            return $produits;
        } else {
            return [];
        }
    }

    public function read_one(int $id)
    {
        $stmt = $this->pdo->prepare($this->query_select() . ' WHERE p.id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            if($row){
                $image = isset($row['image']) ? $row['image'] : null;
                $special = isset($row['special_id']) && isset($row['special']) ? new Special($row['special_id'], $row['special']) : null;
                $description = isset($row['description']) ? $row['description'] : null;
                return new Produit(
                    $row['id'],
                    $row['nom'],
                    $row['prix'],
                    $row['inStock'],
                    new Categorie($row['categorie_id'], $row['categorie']),
                    $row['date_ajout'],
                    $description,
                    $image,
                    $special
                );
                
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function read_limit(int $limit)
    {
        $stmt = $this->pdo->prepare($this->query_select() . ' LIMIT :limit');
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $produits = [];
            foreach($result as $row){
                $image = isset($row['image']) ? $row['image'] : null;
                $special = isset($row['special_id']) && isset($row['special']) ? new Special($row['special_id'], $row['special']) : null;
                $description = isset($row['description']) ? $row['description'] : null;
                $produit = new Produit(
                    $row['id'],
                    $row['nom'],
                    $row['prix'],
                    $row['inStock'],
                    new Categorie($row['categorie_id'], $row['categorie']),
                    $row['date_ajout'],
                    $description,
                    $image,
                    $special
                );
                array_push($produits, $produit);
            }
            $stmt->closeCursor();
            return $produits;   
        } else {
            return [];
        }
    }

    public function read_by_categorie(int $categorie_id)
    {
        $stmt = $this->pdo->prepare($this->query_select() . ' WHERE p.fkIdCategorie = :categorie_id');
        $stmt->bindParam(':categorie_id', $categorie_id, PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $produits = [];
            foreach($result as $row){
                $image = isset($row['image']) ? $row['image'] : null;
                $special = isset($row['special_id']) && isset($row['special']) ? new Special($row['special_id'], $row['special']) : null;
                $description = isset($row['description']) ? $row['description'] : null;
                $produit = new Produit(
                    $row['id'],
                    $row['nom'],
                    $row['prix'],
                    $row['inStock'],
                    new Categorie($row['categorie_id'], $row['categorie']),
                    $row['date_ajout'],
                    $image,
                    $special,
                    $description
                );
                array_push($produits, $produit);
            }
            $stmt->closeCursor();
            return $produits;   
        } else {
            return [];
        }
    }
    public function search(string $keyword)
    {
        $stmt = $this->pdo->prepare($this->query_select() . ' WHERE p.nom LIKE :keyword OR p.description LIKE :keyword');
        $keyword = htmlspecialchars(strip_tags($keyword));
        $keyword = "%$keyword%";
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);

        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $produits = [];
            foreach($result as $row){
                $image = isset($row['image']) ? $row['image'] : null;
                $special = isset($row['special_id']) && isset($row['special']) ? new Special($row['special_id'], $row['special']) : null;
                $description = isset($row['description']) ? $row['description'] : null;
                $produit = new Produit(
                    $row['id'],
                    $row['nom'],
                    $row['prix'],
                    $row['inStock'],
                    new Categorie($row['categorie_id'], $row['categorie']),
                    $row['date_ajout'],
                    $image,
                    $special,
                    $description
                );
                array_push($produits, $produit);
            }
            $stmt->closeCursor();
            return $produits;   
        } else {
            return [];
        }
    }

    public function delete (int $id)
    {
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare('DELETE FROM produit_categories WHERE fkIdProduit = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            $stmt = $this->pdo->prepare('DELETE FROM produit_specials WHERE fkIdProduit = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            $stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            $this->pdo->commit();
            return true;

        } catch (Exception $e){
            $this->pdo->rollBack();
            return false;
        }

    }

    public function create (array $data)
    {
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($this->query_insert());
            $data = $this->prepare_data($data);
            $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(':prix', $data['prix'], PDO::PARAM_STR);
            $stmt->bindParam(':inStock', $data['inStock'], PDO::PARAM_STR);
            $stmt->bindParam(':date_ajout', $data['date_ajout'], PDO::PARAM_STR);
            $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $produit_id = $this->pdo->lastInsertId();
            $stmt = $this->pdo->prepare('INSERT INTO produit_categorie (fkIdProduit, fkIdCategorie) VALUES (:fkIdProduit, :fkIdCategorie)');
            $stmt->bindParam(':fkIdProduit', $produit_id, PDO::PARAM_INT);
            $stmt->bindValue(':fkIdCategorie', $data['categorie']->get_value_of('id'), PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            
            $stmt = $this->pdo->prepare('INSERT INTO produit_special (fkIdProduit, fkIdSpecial) VALUES (:fkIdProduit, :fkIdSpecial)');
            $stmt->bindParam(':fkIdProduit', $produit_id, PDO::PARAM_INT);
            $stmt->bindValue(':fkIdSpecial', $data['special']->get_value_of('id'), PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
    
            $this->pdo->commit();
            return true;
        } catch (Exception $e){
            $this->pdo->rollBack();
            return false;
        }
    }
}
