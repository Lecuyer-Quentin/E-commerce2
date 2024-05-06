<?php
require_once '../../config/db.php';
require_once '../../page.inc.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['id']) || empty($_POST['id']) || !is_numeric($_POST['id'])) {
        $error['id'] = 'id is required';
    }
    if(!isset($_POST['nom']) || empty($_POST['nom'])) {
        $error['nom'] = 'nom is required';
    }

    $id = intval(strip_tags(htmlspecialchars($_POST['id'])));
    $nom = strip_tags(htmlspecialchars($_POST['nom']));

    try {
        $category = new CategorieRepo($pdo);
        $category = $category->update($id, $nom);
        $response = [
            'status' => 'success',
            'message' => 'La catégorie ' . $nom . ' a été modifiée avec succès',
            'redirect' => $_SERVER['HTTP_REFERER']
        ];
    } catch (Exception $e) {
        $error['category'] = $e->getMessage();
    }

    if(!empty($error)) {
        $response = [
            'status' => 'error',
            'message' => 'Error',
        ];
    }

    echo json_encode($response);
    exit;
}