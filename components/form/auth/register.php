<?php
    $data_register_form = get_JSON('config.json', 'form', 'register');
    $form_register = new Form($data_register_form);
    echo $form_register->generate_form();
    //$data_register_modal = get_JSON('config.json', 'modal', 'register');
    //$data_register_modal['body'] = $form_register->generate_form();
    //$modal_register = new Modal($data_register_modal);
   // echo $modal_register->generate_modal();
    //echo $modal_register;