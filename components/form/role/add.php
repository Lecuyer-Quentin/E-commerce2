<?php

$data_role_add = get_JSON('config.json', 'form', 'role_add');
$form_role_add = new Form($data_role_add);
echo $form_role_add->generate_form();