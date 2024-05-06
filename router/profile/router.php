<?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'profile';
    $page =  basename($page);
    $section = isset($_GET['section']) ? $_GET['section'] : '';
    $section =  basename($section);

    function renderProfileSection($page, $section) {
        $render = '<section class="container container-fluid container-' . $section . '">';
            $render .= include_once('views/' . $page . '/' . $section . '/index.php');
        $render .= '</section>';
        return $render;
    }
    renderProfileSection($page, $section);