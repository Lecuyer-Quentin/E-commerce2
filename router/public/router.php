<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page =  basename($page);
$role = isset($_SESSION['user']) ? $_SESSION['user']['role'] : 'guest';
$allowedPages = [];

if (($role === 'admin') || ($role === 'dev')) {
    $allowedPages = ['home', 'admin', 'profile'];
} elseif ($role === 'user') {
    $allowedPages = ['home', 'profile'];
} else {
    $allowedPages = ['home', 'login', 'register', 'admin', 'profile'];
}

if (!in_array($page, $allowedPages)) {
    $page = 'denied';
}

if (!file_exists('views/' . $page . '/index.php')) {
    $page = '404';
}

function renderMain($page) {
    $main = '<main class="container container-fluid container-' . $page . '">';
        $main .= include_once('views/' . $page . '/index.php');
    $main .= '</main>';
    return $main;
}

renderMain($page);
