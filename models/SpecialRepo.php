<?php

class SpecialRepo
{
    private PDO $pdo;
    private string $table = 'special';

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
            $specials = [];
            foreach($result as $row) {
                $special = new Special($row['id'], $row['nom']);
                array_push($specials, $special);
            }
            $stmt->closeCursor();
            return $specials;
        } else {
            return false;
        }
    }

    public function read_one(int $id)
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            if($result) {
                return new Special($result['id'], $result['nom']);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function create(string $nom)
    {
        $query = "INSERT INTO $this->table (nom) VALUES (:nom)";
        $stmt = $this->pdo->prepare($query);
        $nom = strip_tags(htmlspecialchars($nom));
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
        try {
            $this->pdo->beginTransaction();

            $query = "UPDATE $this->table SET nom = :nom WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
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
            $stmt = $this->pdo->prepare("DELETE FROM produit_special WHERE fkIdSpecial = :id");
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