<?php
require_once '../../config/db.php';
require_once '../../page.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(!isset($_POST['id']) || empty($_POST['id'])) {
        $errors[] = "L'identifiant est obligatoire";
    }

    $id = htmlspecialchars(strip_tags($_POST['id']));

    try{
        $category = new CategorieRepo($pdo);
        $category_name = $category->read_one($id)->get_value_of('nom');
        $category->delete($id);
        $response = [
            'status' => 'success',
            'message' => 'La catégorie ' . $category_name . ' a été supprimée avec succès',
            'redirect' => $_SERVER['HTTP_REFERER']
        ];
    } catch(PDOException $e) {
        $response = [
            'status' => 'error',
            'message' => 'Erreur lors de la suppression de la catégorie'
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