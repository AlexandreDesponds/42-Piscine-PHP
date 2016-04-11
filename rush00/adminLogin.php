<?php
    session_start();

    if (isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {
        header('Location: admin.php');
        exit();
    }
    include('partial/head.php');
?>
<body class="small">
    <div class="reg-log">
        <div class="circle"></div>
        <h1>Connexion admin</h1>
        <form action="controller/admin.php" method="POST">
            <input type="text" name="pseudo" placeholder="Ton pseudo" class="" value="">
            <input type="password" name="password" placeholder="Ton mot de passe" class="">
            <button type="submit" class="btn btn-default">S'identifier</button>
            <input type="hidden" name="from" value="adminLogin">
            <input type="hidden" name="success" value="admin">
        </form>
    </div>
