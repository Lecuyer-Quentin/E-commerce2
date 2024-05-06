<?php
    $data_category_add = get_JSON('config.json', 'form', 'categorie_add');
    $form_category_add = new Form($data_category_add);
    echo $form_category_add->generate_form();