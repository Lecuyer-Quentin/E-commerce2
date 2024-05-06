<section>
    <?php
    global $pdo;
    $products = new ProduitRepo($pdo);
    $products = $products->read_all();

    if(isset($products)) {
        foreach($products as $product) : ?>
            <div class="card" style="width: 18rem;">
                <img src="<?= $product->get_value_of('image') ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"
                    ><?php echo $product ?></h5>
                    <p class="card-text"><?= $product->get_value_of('prix') ?></p>
                    <p class="card-text"><?= $product->get_value_of('description') ?></p>
                    <p class="card-text"><?= $product->get_value_of('inStock') ?></p>
                    <p class="card-text"><?= $product->get_value_of('categorie') ?></p>
                    <p class="card-text"><?= $product->get_value_of('special') ?></p>
                    <p class="card-text"><?= $product->get_value_of('dateAjout') ?></p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        <?php endforeach;
    }
    ?>
</section>

<section>
    <?php
    $data = get_JSON('config.json', 'view', 'home');
    $users = new UtilisateurRepo($pdo);
    $users = $users->read_all();
    
    if(isset($users)) {
        foreach($users as $user) : ?>
            <div class="card" style="width: 18rem;">
                <img src="<?= $user->get_value_of('avatar') ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $user ?></h5>
                    <p class="card-text"><?= $user->get_value_of('email') ?></p>
                    <p class="card-text"><?= $user->get_value_of('role') ?></p>
                    <p class="card-text"><?= $user->get_value_of('role')->get_value_of('id') ?></p>
                    <p class="card-text"><?= $user->get_value_of('date_inscription') ?></p>
                    <p class="card-text"><?= $user->get_value_of('isActif') ?></p>
                    <p class="card-text"><?= $user->get_value_of('token') ?></p>
                    <p class="card-text"><?= $user->get_value_of('numRue') ?></p>
                    <p class="card-text"><?= $user->get_value_of('nomRue') ?></p>
                    <p class="card-text"><?= $user->get_value_of('ville') ?></p>
                    <p class="card-text"><?= $user->get_value_of('codePostal') ?></p>
                    <p class="card-text"><?= $user->get_value_of('pays') ?></p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        <?php endforeach;
    }

    if(isset($data['header'])) {
        foreach($data['header'] as $item) {
            echo '<'.$item['type'].'>' . $item['line'] . '</'.$item['type'].'>';
        }
    }

    if(isset($data['content'])) {
        foreach($data['content'] as $items) {
            foreach($items as $item) {
                echo '<'.$item['type'].'>' . $item['line'] . '</'.$item['type'].'>';
            }
        }
    }
    ?>
</section>

<section>
    <?php
    require_once 'components/form/product/add.php';
    //require_once 'components/form/product/edit.php';
    $product = new ProduitRepo($pdo);
    $product = $product->read_all();

    if(isset($product)){
        $table = "<table class='table'>";
        $table .= "<thead>";
        $table .= "<tr>";
        $table .= "<th scope='col'>#</th>";
        $table .= "<th scope='col'>Nom</th>";
        $table .= "<th scope='col'>Prix</th>";
        $table .= "<th scope='col'>Description</th>";
        $table .= "<th scope='col'>En stock</th>";
        $table .= "<th scope='col'>Categorie</th>";
        $table .= "<th scope='col'>Special</th>";
        $table .= "<th scope='col'>Date d'ajout</th>";
        $table .= "<th scope='col'>Actions</th>";
        $table .= "</tr>";

        $table .= "</thead>";
        $table .= "<tbody>";
        foreach($product as $item) {
            $data_product_delete = get_JSON('config.json', 'form', 'product_delete');
            $data_product_delete['inputs'][0]['value'] = $item->get_value_of('id');
            $form_product_delete = new Form($data_product_delete);

            $data_product_edit = get_JSON('config.json', 'form', 'product_edit');
            $data_product_edit['inputs'][0]['value'] = $item->get_value_of('id');
            $form_product_edit = new Form($data_product_edit);

            $table .= "<tr>";
            $table .= "<th scope='row'>" . $item->get_value_of('id') . "</th>";
            $table .= "<td>" . $item->get_value_of('nom') . "</td>";
            $table .= "<td>" . $item->get_value_of('prix') . "</td>";
            $table .= "<td>" . $item->get_value_of('description') . "</td>";
            $table .= "<td>" . $item->get_value_of('inStock') . "</td>";
            $table .= "<td>" . $item->get_value_of('categorie') . "</td>";
            $table .= "<td>" . $item->get_value_of('special') . "</td>";
            $table .= "<td>" . $item->get_value_of('dateAjout') . "</td>";
            $table .= "<td>";
                $table .= $form_product_delete->generate_form();
                $table .= $form_product_edit->generate_form();
            $table .= "</td>";
            $table .= "</tr>";
        }
        $table .= "</tbody>";
        $table .= "</table>";
        echo $table;
    }
    ?>

</section>

<section>
    <?php
    require_once 'components/form/user/add.php';
    $user = new UtilisateurRepo($pdo);
    $user = $user->read_all();

    if(isset($user)) {
        $table = "<table class='table'>";
        $table .= "<thead>";
        $table .= "<tr>";
        $table .= "<th scope='col'>#</th>";
        $table .= "<th scope='col'>Nom</th>";
        $table .= "<th scope='col'>Email</th>";
        $table .= "<th scope='col'>Role</th>";
        $table .= "<th scope='col'>Date d'inscription</th>";
        $table .= "<th scope='col'>Actif</th>";
        $table .= "<th scope='col'>Token</th>";
        $table .= "<th scope='col'>Numéro de rue</th>";
        $table .= "<th scope='col'>Nom de rue</th>";
        $table .= "<th scope='col'>Ville</th>";
        $table .= "<th scope='col'>Code postal</th>";
        $table .= "<th scope='col'>Pays</th>";
        $table .= "<th scope='col'>Actions</th>";
        $table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody>";
        foreach($user as $item) {
            $data_user_delete = get_JSON('config.json', 'form', 'user_delete');
            $data_user_delete['inputs'][0]['value'] = $item->get_value_of('id');
            $form_user_delete = new Form($data_user_delete);

            $data_user_edit = get_JSON('config.json', 'form', 'user_edit');
            $data_user_edit['inputs'][0]['value'] = $item->get_value_of('id');
            $form_user_edit = new Form($data_user_edit);

            $table .= "<tr>";
            $table .= "<th scope='row'>" . $item->get_value_of('id') . "</th>";
            $table .= "<td>" . $item->get_value_of('nom') . "</td>";
            $table .= "<td>" . $item->get_value_of('email') . "</td>";
            $table .= "<td>" . $item->get_value_of('role') . "</td>";
            $table .= "<td>" . $item->get_value_of('date_inscription') . "</td>";
            $table .= "<td>" . $item->get_value_of('isActif') . "</td>";
            $table .= "<td>" . $item->get_value_of('token') . "</td>";
            $table .= "<td>" . $item->get_value_of('numRue') . "</td>";
            $table .= "<td>" . $item->get_value_of('nomRue') . "</td>";
            $table .= "<td>" . $item->get_value_of('ville') . "</td>";
            $table .= "<td>" . $item->get_value_of('codePostal') . "</td>";
            $table .= "<td>" . $item->get_value_of('pays') . "</td>";
            $table .= "<td>";
                $table .= $form_user_delete->generate_form();
                $table .= $form_user_edit->generate_form();
            $table .= "</td>";
            $table .= "</tr>";
        }
        $table .= "</tbody>";
        $table .= "</table>";
        echo $table;
    }
    ?>

</section>

<section>
    <?php
require_once 'components/form/special/add.php';
$special = new SpecialRepo($pdo);
$special = $special->read_all();

if(isset($special)) {
    $table = "<table class='table'>";
    $table .= "<thead>";
    $table .= "<tr>";
    $table .= "<th scope='col'>#</th>";
    $table .= "<th scope='col'>Nom</th>";
    $table .= "<th scope='col'>Actions</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach($special as $item) {
        $data_special_delete = get_JSON('config.json', 'form', 'special_delete');
        $data_special_delete['inputs'][0]['value'] = $item->get_value_of('id');
        $form_special_delete = new Form($data_special_delete);

        $data_special_edit = get_JSON('config.json', 'form', 'special_edit');
        $data_special_edit['inputs'][0]['value'] = $item->get_value_of('id');
        $form_special_edit = new Form($data_special_edit);

        $table .= "<tr>";
        $table .= "<th scope='row'>" . $item->get_value_of('id') . "</th>";
        $table .= "<td>" . $item->get_value_of('nom') . "</td>";
        $table .= "<td>";
            $table .= $form_special_delete->generate_form();
            $table .= $form_special_edit->generate_form();
        $table .= "</td>";

        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "</table>";
    echo $table;
}

?>
</section>

<section>
    <?php
    require_once 'components/form/category/add.php';

    $category = new CategorieRepo($pdo);
    $category = $category->read_all();

    if(isset($category)) {
        $table = "<table class='table'>";
        $table .= "<thead>";
        $table .= "<tr>";
        $table .= "<th scope='col'>#</th>";
        $table .= "<th scope='col'>Nom</th>";
        $table .= "<th scope='col'>Actions</th>";
        $table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody>";
        foreach($category as $item) {
            $data_category_delete = get_JSON('config.json', 'form', 'categorie_delete');
            $data_category_delete['inputs'][0]['value'] = $item->get_value_of('id');
            $form_category_delete = new Form($data_category_delete);

            $data_category_edit = get_JSON('config.json', 'form', 'categorie_edit');
            $data_category_edit['inputs'][0]['value'] = $item->get_value_of('id');
            $form_category_edit = new Form($data_category_edit);

            $table .= "<tr>";
            $table .= "<th scope='row'>" . $item->get_value_of('id') . "</th>";
            $table .= "<td>" . $item->get_value_of('nom') . "</td>";
            $table .= "<td>";
                $table .= $form_category_delete->generate_form();
                $table .= $form_category_edit->generate_form();
            $table .= "</td>";
            $table .= "</tr>";
        }
        $table .= "</tbody>";
        $table .= "</table>";
        echo $table;
    }
    ?>
</section>

<section></section>
    <?php
    require_once 'components/form/role/add.php';

    $role = new RoleRepo($pdo);
    $role = $role->read_all();

    if(isset($role)) {
        $table = "<table class='table'>";
        $table .= "<thead>";
        $table .= "<tr>";
        $table .= "<th scope='col'>#</th>";
        $table .= "<th scope='col'>Nom</th>";
        $table .= "<th scope='col'>Actions</th>";
        $table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody>";
        foreach($role as $item) {
            $data_role_delete = get_JSON('config.json', 'form', 'role_delete');
            $data_role_delete['inputs'][0]['value'] = $item->get_value_of('id');
            $form_role_delete = new Form($data_role_delete);

            $data_role_edit = get_JSON('config.json', 'form', 'role_edit');
            $data_role_edit['inputs'][0]['value'] = $item->get_value_of('id');
            $form_role_edit = new Form($data_role_edit);

            $table .= "<tr>";
            $table .= "<th scope='row'>" . $item->get_value_of('id') . "</th>";
            $table .= "<td>" . $item->get_value_of('nom') . "</td>";
            $table .= "<td>";
                $table .= $form_role_delete->generate_form();
                $table .= $form_role_edit->generate_form();
            $table .= "</td>";
            $table .= "</tr>";
        }
        $table .= "</tbody>";
        $table .= "</table>";
        echo $table;
    }
    ?>
</section>
    