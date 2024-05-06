<?php
    global $pdo;
    $rolesRepo = new RoleRepo($pdo);
    $data_user_add_form = get_JSON('config.json', 'form', 'user_add');
   
    // Add options to the select input
    $data_user_add_form['inputs'] = array_map(function($input) use ($rolesRepo) {
        if($input['name'] === 'role') {
            $input['options'] = $rolesRepo->read_all();
        }
        return $input;
    }, $data_user_add_form['inputs']);

    $form_user_add = new Form($data_user_add_form);
    echo $form_user_add->generate_form();
