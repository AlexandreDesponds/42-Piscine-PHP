<?php
    session_start();

    if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo'])) {
        header('Location: index.php');
        exit();
    }
    include('partial/head.php');
?>
<body class="small">
    <div class="reg-log">
        <div class="circle"></div>
        <h1>Connexion</h1>
        <form action="controller/people.php" method="POST">
            <input type="text" name="pseudo" placeholder="Ton pseudo" class="" value="">
            <input type="password" name="password" placeholder="Ton mot de passe" class="">
            <button type="submit" class="btn btn-default">S'identifier</button>
            <input type="hidden" name="from" value="login">
            <input type="hidden" name="success" value="index">
            <p>Tu n'es pas encore inscrit ? <a href="register.php">Inscris toi</a></p>
        </form>
    </div>