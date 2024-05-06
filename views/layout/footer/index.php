<?php
    $data = get_JSON('config.json', 'view', 'footer');
?>

<footer>
    <?php
        foreach($data as $items) {
            $list = "<div class='$items[class]'>";
            $list .= "<h3>$items[title]</h3>";
                $list .= "<ul>";
                    foreach($items['items'] as $link) {
                        $list .= "<li><a href='$link[value]'>$link[label]</a></li>";
                    }
                $list .= "</ul>";
            $list .= "</div>";
            echo $list;
        }
    ?>

    <div>
        <p>&copy; 2024 - All rights reserved</p>
    </div>
</footer>