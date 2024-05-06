<?php

$user_session = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$user_role = isset($user_session) ? $user_session['role'] : 'guest';


?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <?php if($user_session): ?>
            <span class="d-md-block">Bonjour <?php echo $_SESSION['user']['nom'] . ' ' . $_SESSION['user']['prenom']; ?></span>
            <form action="controllers/auth/logout.php" method="post">
                <button type="submit" class="btn btn-primary">Déconnexion</button>
            </form>
        <?php else: ?>
            <? require_once 'components/form/auth/login.php'; ?>
            <? require_once 'components/form/auth/register.php'; ?>
        <?php endif; ?>
    </div>
</nav>
