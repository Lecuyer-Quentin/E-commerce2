<?php
session_start();
require_once '../../config/db.php';
require_once '../../page.inc.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if (!isset($_POST['email']) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) 
    || (!isset($_POST['password']) || empty($_POST['password']))) {
        $errors = 'Veuillez remplir tous les champs';
    }

    $email = strip_tags(htmlspecialchars($_POST['email']));
    $password = strip_tags(htmlspecialchars($_POST['password']));
    
    try {
        $user = new UtilisateurRepo($pdo);
        $check_user = $user->auth($email, $password);

        if ($check_user) {
            set_session('user', [
                'id' => $check_user->get_value_of('id'),
                'nom' => $check_user->get_value_of('nom'),
                'prenom' => $check_user->get_value_of('prenom'),
                'email' => $check_user->get_value_of('email'),
                'role' => $check_user->get_value_of('role'),
                //'date_inscription' => $check_user->get_value_of('date_inscription'),
                //'isActif' => $check_user->get_value_of('isActif'),
                //'token' => $check_user->get_value_of('token'),
                //'numRue' => $check_user->get_value_of('numRue'),
                //'nomRue' => $check_user->get_value_of('nomRue'),
                //'ville' => $check_user->get_value_of('ville'),
                //'codePostal' => $check_user->get_value_of('codePostal'),
                //'pays' => $check_user->get_value_of('pays'),
                //'avatar' => $check_user->get_value_of('avatar'),
            ]);
            setcookie('user', $check_user->get_value_of('id'), time() + 3600, '/');
            $username = $_SESSION['user']['nom'] . ' ' . $_SESSION['user']['prenom'];
            $response = array(
                'status' => 'success',
                'message' => 'Bonjour ' . $username . ', vous allez être redirigé vers la page d\'accueil',
                'redirect' => $_SERVER['HTTP_REFERER'],
            );
        } else {
            $errors = 'Email ou mot de passe incorrect';
        }
    } catch (Exception $e) {
        $msg = 'Erreur lors de la connexion : ' . $e->getMessage();
        $errors = $msg;
    }

    if(!empty($errors)){
        $response = array(
            'status' => 'error',
            'message' => $errors,
        );
    }
    
    echo json_encode($response);
    exit;

}