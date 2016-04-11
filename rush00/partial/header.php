<?php include('head.php'); ?>
<header class="row">
    <div class="col-l-2 col-m-12 col-s-12 logo">
        <a href="index.php"><img src="img/logo.png" alt=""></a>
    </div>
    <div class="col-l-6 col-m-8 col-s-12 menu">
        <a href="index.php">HOME</a> |
        <a href="browse.php">PARCOURIR LES DVD</a> |
        <a href="basket.php"><?php echo isset($_SESSION['basketCount']) ? $_SESSION['basketCount']  : "0";?> ARTICLES - <?php echo isset($_SESSION['basketPrice']) ? number_format($_SESSION['basketPrice'], 2) : '0.00'; ?> €</a>
    </div>
    <div class="col-l-4 col-m-4 col-s-12 login">
        <?php
            if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo'])) {
                echo '<a href="member.php">Bonjour '.$_SESSION['pseudo'].'</a> | <a href="logout.php">Déconnexion</a>';
            } else {
                echo '<a href="register.php">Inscription</a> | <a href="login.php">Connexion</a>';
            }
        ?>
    </div>
</header>