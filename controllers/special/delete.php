<?php
require_once '../../config/db.php';
require_once '../../page.inc.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['id'])) {
        $error['id'] = 'id is required';
    }

    $id = intval(strip_tags(htmlspecialchars($_POST['id'])));

    try {
        $special = new SpecialRepo($pdo);
        $special_name = $special->read_one($id)->get_value_of('nom');
        $special = $special->delete($id);
        $response = [
            'status' => 'success',
            'message' => 'Le spécial ' . $special_name . ' a été supprimé avec succès',
            'redirect' => $_SERVER['HTTP_REFERER']
        ];
    } catch (Exception $e) {
        $error['special'] = $e->getMessage();
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
