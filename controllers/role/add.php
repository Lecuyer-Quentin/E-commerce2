<?php
require_once '../../config/db.php';
require_once '../../page.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!isset($_POST['nom']) || empty($_POST['nom'])) {
        $errors['nom'] = 'Le nom est obligatoire';
    }
    $nom = strip_tags(htmlspecialchars($_POST['nom']));

    try{
        $role = new RoleRepo($pdo);
        $role->create($nom);
        $response = [
            'status' => 'success',
            'message' => 'Le rôle ' . $nom . ' a été ajouté avec succès',
            'redirect' => $_SERVER['HTTP_REFERER']
        ];
    } catch(PDOException $e) {
        $errors['bdd'] = 'Erreur lors de l\'ajout du rôle : ' . $e->getMessage();
    }

    if(!empty($errors)) {
        $response = [
            'status' => 'error',
            'message' => 'Erreur lors de l\'ajout du rôle',
        ];
    }
    echo json_encode($response);
    exit;
}