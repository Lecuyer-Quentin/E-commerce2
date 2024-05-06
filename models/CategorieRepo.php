<?php

class CategorieRepo 
{
    private PDO $pdo;
    private string $table = 'categorie';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function read_all()
    {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->pdo->query($query);
        if($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categories = [];
            foreach($result as $row) {
                $categorie = new Categorie($row['id'], $row['nom']);
                array_push($categories, $categorie);
            }
            $stmt->closeCursor();
            return $categories;
        } else {
            return false;
        }
    }

    public function read_one($id)
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            if($result) {
                return new Categorie($result['id'], $result['nom']);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function create(string $nom)
    {
        $query = "INSERT INTO $this->table (nom) VALUES (:nom)";
        $stmt = $this->pdo->prepare($query);
        $nom = htmlspecialchars(strip_tags($nom));
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        if($stmt->execute()) {
            $stmt->closeCursor();
            return true;
        } else {
            return false;
        }
    }

    public function update(int $id, string $nom)
    {
        try{
            $this->pdo->beginTransaction();

            $query = "UPDATE $this->table SET nom = :nom WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            
            $stmt = $this->pdo->prepare("UPDATE produit_categorie SET fkIdCategorie = :id WHERE fkIdCategorie = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM produit_categorie WHERE fkIdCategorie = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            $query = "DELETE FROM $this->table WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}