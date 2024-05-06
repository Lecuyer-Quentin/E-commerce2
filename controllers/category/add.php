<?php
require_once '../../config/db.php';
require_once '../../page.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(!isset($_POST['nom']) || empty($_POST['nom'])) {
        $errors[] = "Le nom est obligatoire";
    }

    $nom = htmlspecialchars(strip_tags($_POST['nom']));

    try{
        $category = new CategorieRepo($pdo);
        $category->create($nom);
        $response = [
            'status' => 'success',
            'message' => 'La catégorie ' . $nom . ' a été ajoutée avec succès',
            'redirect' => $_SERVER['HTTP_REFERER']
        ];
    } catch(PDOException $e) {
        $response = [
            'status' => 'error',
            'message' => 'Erreur lors de l\'ajout de la catégorie'
        ];   
    }

    if(!empty($errors)) {
        $response = [
            'status' => 'error',
            'message' => $errors
        ];
    }

    echo json_encode($response);
    exit;
}