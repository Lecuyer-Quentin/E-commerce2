<?php 

class CommandeRepo
{
    private PDO $pdo;
    private string $table = 'commande';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function query_select(){
        $query = 'SELECT c.*, u.nom as nom, u.prenom as prenom, u.email as email, p.nom as produit, p.prix as prix FROM ' . $this->table . ' c';
        $query .= ' LEFT JOIN utilisateur_commande uc ON c.id = uc.fkIdCommande';
        $query .= ' LEFT JOIN utilisateur u ON uc.fkIdUtilisateur = u.id';
        $query .= ' LEFT JOIN commande_produit cp ON c.id = cp.fkIdCommande';
        $query .= ' LEFT JOIN produit p ON cp.fkIdProduit = p.id';
        return $query;
    }

    public function read_all()
    {
        $query = $this->query_select();
        $stmt = $this->pdo->query($query);
        if($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $commandes = [];
            foreach($result as $row) {
                $commande = new Commande(
                    $row['id'], $row['date'],
                    [
                        //! A vérifier
                        new Utilisateur(
                            $row['fkIdUtilisateur'],
                            $row['nom'],
                            $row['prenom'],
                            $row['email'],null,null,null,null,null,null,null,null,null,null,null,
                        )
                    ],
                    [
                        //! A vérifier
                        new Produit(
                            $row['fkIdProduit'],
                            $row['produit'],
                            $row['prix'], null, null, null, null, null, null,
                        )
                    ]
                );
                array_push($commandes, $commande);
            }
            $stmt->closeCursor(); //! Important : libère les ressources
            return $commandes;
        } else {
            return false;
        }
    }

    public function read_one($id)
    {
        $query = $this->query_select() . ' WHERE c.id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $commande = new Commande(
                $result['id'], $result['date'],
                [
                    //! A vérifier
                    new Utilisateur(
                        $result['fkIdUtilisateur'],
                        $result['nom'],
                        $result['prenom'],
                        $result['email'],null,null,null,null,null,null,null,null,null,null,null,
                    )
                ],
                [
                    //! A vérifier
                    new Produit(
                        $result['fkIdProduit'],
                        $result['produit'],
                        $result['prix'], null, null, null, null, null, null,
                    )
                ]
            );
            $stmt->closeCursor(); //! Important : libère les ressources
            return $commande;
        } else {
            return false;
        }
    }

    
}