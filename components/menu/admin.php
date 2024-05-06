<?php
    $data = get_JSON('config.json', 'menu', 'admin');
    $items = $data['items'];
?>

<nav class="navbar navbar-expand-md navbar-light bg-light">

    <button class="navbar-toggler mt-1 border-0 shadow-none focus:outline-none focus:ring-0" type="button" data-bs-toggle="collapse" data-bs-target="#admin_menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="admin_menu">
        <ul class="navbar-nav flex-row justify-content-center flex-wrap">
            <?php foreach($items as $item): ?>
                <li class="nav-item mx-1">
                    <a href="<?php echo $item['value']; ?>" class="nav-link">
                        <strong><?php echo $item['label']; ?></strong>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>