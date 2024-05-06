<?php

class RoleRepo
{
    private PDO $pdo;
    private string $table = 'role';

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
            $roles = [];
            foreach($result as $row) {
                $role = new Role($row['id'], $row['nom']);
                array_push($roles, $role);
            }
            $stmt->closeCursor();
            return $roles;
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
                return new Role($result['id'], $result['nom']);
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
            
            $stmt = $this->pdo->prepare("UPDATE utilisateur_role SET fkIdRole = :id WHERE fkIdRole = :id");
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
             //! A vérifier
             $stmt = $this->pdo->prepare("DELETE FROM utilisateur_role WHERE fkIdRole = :id");
             $stmt->bindValue(':id', $id, PDO::PARAM_INT);
             $stmt->execute();
             $stmt->closeCursor();
             //! A vérifier
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