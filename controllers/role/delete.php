<?php
require_once '../../config/db.php';
require_once '../../page.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = htmlspecialchars(strip_tags($_POST['id']));
    try{
        $role = new RoleRepo($pdo);
        $nom = $role->read_one($id)->get_value_of('nom');
        $role->delete($id);
        $response = [
            'status' => 'success',
            'message' => 'Le rôle ' . $nom . ' a été supprimé avec succès',
            'redirect' => $_SERVER['HTTP_REFERER']
        ];
    } catch(PDOException $e) {
        $response = [
            'status' => 'error',
            'message' => 'Erreur lors de la suppression du rôle'
        ];   
    }
    echo json_encode($response);
    exit;
}