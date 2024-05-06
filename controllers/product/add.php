<?php
require_once '../../config/db.php';
require_once '../../page.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(!isset($_POST['nom']) || empty($_POST['nom'])
    || !isset($_POST['prix']) || empty($_POST['prix']) || !is_numeric($_POST['prix'])
    || !isset($_POST['categorie']) || empty($_POST['categorie'])
    || !isset($_POST['special']) || empty($_POST['special'])
    || !isset($_POST['description']) || empty($_POST['description'])
    ) {
        $errors = 'Veuillez remplir tous les champs';
    }

    $nom = strip_tags(htmlspecialchars($_POST['nom']));
    $prix = floatval(strip_tags(htmlspecialchars($_POST['prix'])));
    $categorie = intval(strip_tags(htmlspecialchars($_POST['categorie'])));
    $special = intval(strip_tags(htmlspecialchars($_POST['special'])));
    $description = strip_tags(htmlspecialchars($_POST['description']));

    $image = null;
    if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {
        $rep = get_directory('images/products/');
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_path = $rep . uniqid() . '.' . $extension;
        move_uploaded_file($_FILES['image']['tmp_name'], $new_path);
        $image = basename($new_path);
    }

    try {
        $product = new ProduitRepo($pdo);
        $categorieRepo = new CategorieRepo($pdo);
        $specialRepo = new SpecialRepo($pdo);
        $categorie = $categorieRepo->read_one($categorie);
        $special = $specialRepo->read_one($special);
        $id_cat = $categorie->get_value_of('id');
        $id_spe = $special->get_value_of('id');

        $product->create([
            'nom' => $nom,
            'prix' => $prix,
            'categorie' => $categorie,
            'special' => $special,
            'description' => $description,
            'image' => $image,
            'inStock' => 1,
        ]);

        $response = array(
            'status' => 'success',
            'message' => "Le Produit " . $nom . " a été ajouté avec succès.". "<br />" . "Categorie: " . $categorie . "<br />" . "Special: " . $special,
            'redirect' => $_SERVER['HTTP_REFERER']
        );
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => $e->getMessage(),
        );
    }

    echo json_encode($response);
    exit;
}


