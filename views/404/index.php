<section>
<h1>404</h1>
    <p>Page not found</p>
    <p>Sorry, the page you are looking for does not exist.</p>
    <?php
   
    if (isset($_SERVER['HTTP_REFERER'])) {
        echo "<a href='{$_SERVER['HTTP_REFERER']}'>Go back to the previous page</a>";
    } else {
        echo "<a href='index.php?page=home'>Go back to home</a>";
    }
    ?>
</section>