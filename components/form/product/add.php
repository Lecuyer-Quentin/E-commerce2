<?php
global $pdo;
$data_product_add_form = get_JSON('config.json', 'form', 'product_add');
$data_category = new CategorieRepo($pdo);
$data_special = new SpecialRepo($pdo);

// Add options to the select input
$data_product_add_form['inputs'] = array_map(function($input) use ($data_category, $data_special) {
    if($input['name'] === 'categorie') {
        $input['options'] = $data_category->read_all();
    }
    if($input['name'] === 'special') {
        $input['options'] = $data_special->read_all();
    }
    return $input;
}, $data_product_add_form['inputs']);

$form_add_product = new Form($data_product_add_form);
echo $form_add_product->generate_form();