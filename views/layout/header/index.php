<?php
    $data = get_JSON('config.json', 'view', 'header');
    $nav_items = get_JSON('config.json', 'menu', 'navigation');

    function logo() {
        global $data;
        if(isset($data['logo'])) {
            $logo = "<div class='logo'>";
                $logo .= "<a href='index.php'>";
                    $logo .= "<img src='$data[logo]' alt='Logo' width='200' height='200'>";
                $logo .= "</a>";
            $logo .= "</div>";
            return $logo;
        } else {
            return null;
        }
    }
?>

<header>
    <?php 
        echo logo();
        require_once 'components/form/searchBar.php';
        require_once 'components/menu/navigation.php';
    ?>
</header>