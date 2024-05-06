<?
$data_special_add = get_JSON('config.json', 'form', 'special_add');
$form_special_add = new Form($data_special_add);
echo $form_special_add->generate_form();