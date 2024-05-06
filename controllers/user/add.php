<?php 
require_once '../../config/db.php';
require_once '../../page.inc.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(!isset($_POST['nom']) || empty($_POST['nom'])
    || !isset($_POST['prenom']) || empty($_POST['prenom'])
    || !isset($_POST['email']) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    || !isset($_POST['password']) || empty($_POST['password'])
    || !isset($_POST['password_confirm']) || empty($_POST['password_confirm'])
    || !isset($_POST['role']) || empty($_POST['role'])
    ) {
        $errors = 'Veuillez remplir tous les champs';
    }

    $nom = strip_tags(htmlspecialchars($_POST['nom']));
    $prenom = strip_tags(htmlspecialchars($_POST['prenom']));
    $email = strip_tags(htmlspecialchars($_POST['email']));
    $password = strip_tags(htmlspecialchars($_POST['password']));
    $password_confirm = strip_tags(htmlspecialchars($_POST['password_confirm']));
    $role = intval(strip_tags(htmlspecialchars($_POST['role'])));

    $avatar = null;
    if(isset($_FILES['avatar']['tmp_name']) && !empty($_FILES['avatar']['tmp_name'])) {
        $rep = get_directory('images/avatars/');
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $new_path = $rep . uniqid() . '.' . $extension;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $new_path);
        $avatar = basename($new_path);
    } 

    if($password !== $password_confirm) {
        $errors = 'Les mots de passe ne correspondent pas';
    }

    $numRue = isset($_POST['numRue']) ? strip_tags(htmlspecialchars($_POST['numRue'])) : '';
    $nomRue = isset($_POST['nomRue']) ? strip_tags(htmlspecialchars($_POST['nomRue'])) : '';
    $ville = isset($_POST['ville']) ? strip_tags(htmlspecialchars($_POST['ville'])) : '';
    $codePostal = isset($_POST['codePostal']) ? strip_tags(htmlspecialchars($_POST['codePostal'])) : '';
    $pays = isset($_POST['pays']) ? strip_tags(htmlspecialchars($_POST['pays'])) : '';



    try {
        $user = new UtilisateurRepo($pdo);
        $rolesRepo = new RoleRepo($pdo);
        $role = $rolesRepo->read_one($role);

        $user->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'mot_de_passe' => $password_confirm,
            'role' => $role,
            'avatar' => $avatar,
            'isActif' => 0,
            'token' => bin2hex(random_bytes(32)),
            'numRue' => $numRue,
            'nomRue' => $nomRue,
            'ville' => $ville,
            'codePostal' => $codePostal,
            'pays' => $pays,
        ]);

        $response = array(
            'status' => 'success',
            'message' => 'Utilisateur ' . $nom . ' ' . $prenom . ' ajouté avec succès',
            'redirect' => $_SERVER['HTTP_REFERER'],
        );
      
    } catch (Exception $e) {
        $msg = 'Erreur lors de l\'ajout de l\'utilisateur : ' . $e->getMessage();
        $errors = $msg;
    }

    if(!empty($errors)) {
        $response = array(
            'status' => 'error',
            'message' => $errors,
        );
    }

    echo json_encode($response);
    exit;
}
