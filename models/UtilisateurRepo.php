<?php
require_once 'Utilisateur.php';
require_once 'Role.php';

class UtilisateurRepo
{
    private PDO $pdo;
    private string $table = 'utilisateur';

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // SQL queries \\
    private function query_select()
    {
        $query= 'SELECT u.*, r.nom as role, r.id as role_id FROM ' . $this->table . ' u';
        $query .= ' JOIN utilisateur_role ur ON u.id = ur.fkIdUtilisateur';
        $query .= ' JOIN role r ON ur.fkIdRole = r.id';
        return $query;
    }
    private function query_insert()
    {
        $query = 'INSERT INTO ' . $this->table . ' (nom, prenom, email, mot_de_passe, numRue, nomRue, ville, codePostal, pays, avatar, date_inscription, isActif, token) ';
        $query .= 'VALUES (:nom, :prenom, :email, :mot_de_passe, :numRue, :nomRue, :ville, :codePostal, :pays, :avatar, :date_inscription, :isActif, :token)';
        return $query;
    }
    private function query_update()
    {
        $query = 'UPDATE ' . $this->table . ' ';
        $query .= 'SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, numRue = :numRue, nomRue = :nomRue, ville = :ville, codePostal = :codePostal, pays = :pays, avatar = :avatar, date_inscription = :date_inscription, isActif = :isActif, token = :token ';
        $query .= 'WHERE id = :id';
        return $query;
    }
    // --------------- \\



    // Private functions \\
   private function prepare_data(array $data){
       $data[] = [
           'nom' => htmlspecialchars(strip_tags($data['nom'])),
           'prenom' => htmlspecialchars(strip_tags($data['prenom'])),
           'email' => htmlspecialchars(strip_tags($data['email'])),
           'mot_de_passe' => htmlspecialchars(strip_tags($data['mot_de_passe'])),
           'numRue' => htmlspecialchars(strip_tags($data['numRue'])),
           'nomRue' => htmlspecialchars(strip_tags($data['nomRue'])),
           'ville' => htmlspecialchars(strip_tags($data['ville'])),
           'codePostal' => htmlspecialchars(strip_tags($data['codePostal'])),
           'pays' => htmlspecialchars(strip_tags($data['pays'])),
           'isActif' => intval($data['isActif']),
           'token' => htmlspecialchars(strip_tags($data['token'])),
           'role' => $data['role'],
       ];
         return $data;
    }
   private function prepare_register(array $data){
    $data[] = [
        'nom' => htmlspecialchars(strip_tags($data['nom'])),
        'prenom' => htmlspecialchars(strip_tags($data['prenom'])),
        'email' => htmlspecialchars(strip_tags($data['email'])),
        'mot_de_passe' => htmlspecialchars(strip_tags($data['mot_de_passe'])),
        'isActif' => intval($data['isActif']),
        'token' => htmlspecialchars(strip_tags($data['token'])),
        'role' => $data['role'],
    ];
    return $data;
    }
   private function check_optional_data(array $row){
        if (!array_key_exists('numRue', $row)) {
            $row['numRue'] = null;
        }
        if (!array_key_exists('nomRue', $row)) {
            $row['nomRue'] = null;
        }
        if (!array_key_exists('ville', $row)) {
            $row['ville'] = null;
        }
        if (!array_key_exists('codePostal', $row)) {
            $row['codePostal'] = null;
        }
        if (!array_key_exists('pays', $row)) {
            $row['pays'] = null;
        }
        if (!array_key_exists('avatar', $row)) {
            $row['avatar'] = null;
        }
    }
    // ----------------- \\




    // Public functions \\
    public function read_all(){
        $stmt = $this->pdo->prepare($this->query_select());
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $utilisateurs = [];
            foreach ($result as $row) {
                $this->check_optional_data($row);
                $utilisateur = new Utilisateur(
                    $row['id'],
                    $row['nom'],
                    $row['prenom'],
                    $row['email'],
                    '', // mot de passe
                    new Role($row['role_id'], $row['role']),
                    $row['date_inscription'],
                    $row['isActif'],
                    $row['token'],
                    $row['numRue'],
                    $row['nomRue'],
                    $row['ville'],
                    $row['codePostal'],
                    $row['pays'],
                    $row['avatar'],

                );
                array_push($utilisateurs, $utilisateur);
            }
            $stmt->closeCursor();
            return $utilisateurs;
        } else {
            return false;
        }
    }

    public function read_one(int $id){
      $stmt = $this->pdo->prepare($this->query_select() . ' WHERE u.id = :id');
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      if ($stmt->execute()) {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $stmt->closeCursor();
          if ($row) {
            $this->check_optional_data($row);

              return new Utilisateur(
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['email'],
                '', // mot de passe
                new Role($row['role_id'], $row['role']),
                $row['date_inscription'],
                $row['isActif'],
                $row['token'],
                $row['numRue'],
                $row['nomRue'],
                $row['ville'],
                $row['codePostal'],
                $row['pays'],
                $row['avatar'],
              );
          } else {
              return null;
          }
      } else {
          return null;
      }
    }

    public function read_limit(int $limit){
      $stmt = $this->pdo->prepare($this->query_select() . ' LIMIT :limit');
      $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
      if ($stmt->execute()) {
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $utilisateurs = [];
          foreach ($result as $row) {
            $numRue = $row['numRue'] ?? null;
            $nomRue = $row['nomRue'] ?? null;
            $ville = $row['ville'] ?? null;
            $codePostal = $row['codePostal'] ?? null;
            $pays = $row['pays'] ?? null;
            $avatar = $row['avatar'] ?? null;

              $utilisateur = new Utilisateur(
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['email'],
                '', // mot de passe
                new Role($row['role_id'], $row['role']),
                $row['date_inscription'],
                $row['isActif'],
                $row['token'],
                $numRue,
                $nomRue,
                $ville,
                $codePostal,
                $pays,
                $avatar,
              );
              array_push($utilisateurs, $utilisateur);
          }
          $stmt->closeCursor();
          return $utilisateurs;
      } else {
          return false;
      }
    }

    public function search(string $keyword){
      $stmt = $this->pdo->prepare($this->query_select() . ' WHERE u.nom LIKE :keyword OR u.prenom LIKE :keyword OR u.email LIKE :keyword');
      $keyword = htmlspecialchars(strip_tags($keyword));
      $keyword = "%$keyword%";
      $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);

      if ($stmt->execute()) {
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $utilisateurs = [];
          foreach ($result as $row) {
            $this->check_optional_data($row);

              $utilisateur = new Utilisateur(
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['email'],
                '', // mot de passe
                new Role($row['role_id'], $row['role']),
                $row['date_inscription'],
                $row['isActif'],
                $row['token'],
                $row['numRue'],
                $row['nomRue'],
                $row['ville'],
                $row['codePostal'],
                $row['pays'],
                $row['avatar'],
              );
              array_push($utilisateurs, $utilisateur);
          }
          $stmt->closeCursor();
          return $utilisateurs;
      } else {
          return false;
      }
    }

    public function auth(string $email, string $mot_de_passe){
      $stmt = $this->pdo->prepare($this->query_select() . ' WHERE u.email = :email');
      $email = htmlspecialchars(strip_tags($email));
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
          if ($row) {
              if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
                $this->check_optional_data($row);
                  $utilisateur = new Utilisateur(
                    $row['id'],
                    $row['nom'],
                    $row['prenom'],
                    $row['email'],
                    '', // mot de passe
                    new Role($row['role_id'], $row['role']),
                    $row['date_inscription'],
                    $row['isActif'],
                    $row['token'],
                    $row['numRue'],
                    $row['nomRue'],
                    $row['ville'],
                    $row['codePostal'],
                    $row['pays'],
                    $row['avatar'],
                  );
                    return $utilisateur;
                }
            } else {
                return false;
            }
    }

    public function register(array $data){
      try{
            $this->pdo->beginTransaction();
            $query = 'INSERT INTO ' . $this->table . ' (nom, prenom, email, mot_de_passe, isActif, token) ';
            $query .= 'VALUES (:nom, :prenom, :email, :mot_de_passe, :isActif, :token)';
            $stmt = $this->pdo->prepare($query);
            $data = $this->prepare_register($data);
            $hash_password = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);
            $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $hash_password, PDO::PARAM_STR);
            $stmt->bindParam(':isActif', $data['isActif'], PDO::PARAM_BOOL);
            $stmt->bindParam(':token', $data['token'], PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $id = $this->pdo->lastInsertId();
            $stmt = $this->pdo->prepare('INSERT INTO utilisateur_role (fkIdUtilisateur, fkIdRole) VALUES (:fkIdUtilisateur, :fkIdRole)');
            $stmt->bindParam(':fkIdUtilisateur', $id, PDO::PARAM_INT);
            $stmt->bindValue(':fkIdRole', $data['role']->get_value_of('id'), PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            printf('Erreur : %s.\n', $e->getMessage());
            return false;
        }
    }

    public function create(array $data){
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($this->query_insert());
            $data = $this->prepare_data($data);
            $hash_password = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);
            $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $hash_password, PDO::PARAM_STR);
            $stmt->bindParam(':date_inscription', $data['date_inscription'], PDO::PARAM_STR);
            $stmt->bindParam(':isActif', $data['isActif'], PDO::PARAM_BOOL);
            $stmt->bindParam(':token', $data['token'], PDO::PARAM_STR);
            $stmt->bindParam(':avatar', $data['avatar'], PDO::PARAM_STR);
            $stmt->bindParam(':numRue', $data['numRue'], PDO::PARAM_STR);
            $stmt->bindParam(':nomRue', $data['nomRue'], PDO::PARAM_STR);
            $stmt->bindParam(':ville', $data['ville'], PDO::PARAM_STR);
            $stmt->bindParam(':codePostal', $data['codePostal'], PDO::PARAM_STR);
            $stmt->bindParam(':pays', $data['pays'], PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $id = $this->pdo->lastInsertId();
            $stmt = $this->pdo->prepare('INSERT INTO utilisateur_role (fkIdUtilisateur, fkIdRole) VALUES (:fkIdUtilisateur, :fkIdRole)');
            $stmt->bindParam(':fkIdUtilisateur', $id, PDO::PARAM_INT);
            $stmt->bindValue(':fkIdRole', $data['role']->get_value_of('id'), PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function delete(int $id){
      try{
          $this->pdo->beginTransaction();
          $stmt = $this->pdo->prepare('DELETE FROM utilisateur_role WHERE fkIdUtilisateur = :id');
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->execute();
          $stmt->closeCursor();

          $stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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
    