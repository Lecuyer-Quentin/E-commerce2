<?php
    $data_login_form = get_JSON('config.json', 'form', 'login');
    $form_login = new Form($data_login_form);
    //$data_login_modal = get_JSON('config.json', 'modal', 'login');
    //$data_login_modal['body'] = $form_login->generate_form();
    //$modal_login = new Modal($data_login_modal);
    //echo $modal_login->generate_modal();
    echo $form_login->generate_form();