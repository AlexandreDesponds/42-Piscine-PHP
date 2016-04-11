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
        <h1>Inscription</h1>
        <form action="controller/people.php" method="POST">
            <input type="text" name="pseudo" placeholder="Ton pseudo" value="" class="<?php echo isset($_GET['pseudo']) ? 'error' : '' ; ?>">
            <input type="password" name="password" placeholder="Ton mot de passe" class="<?php echo isset($_GET['password']) ? 'error' : '' ; ?>">
            <input type="password" name="password2" placeholder="Retape ton mot de passe" class="<?php echo isset($_GET['password']) ? 'error' : '' ; ?>">
            <input type="email" name="email" placeholder="Ton email" class="<?php echo isset($_GET['email']) ? 'error' : '' ; ?>">
            <input type="text" name="firstname" placeholder="Ton prenom" class="<?php echo isset($_GET['firstname']) ? 'error' : '' ; ?>">
            <input type="text" name="lastname" placeholder="Ton nom" class="<?php echo isset($_GET['lastname']) ? 'error' : '' ; ?>">
            <input type="text" name="address" placeholder="Ton adresse" class="<?php echo isset($_GET['address']) ? 'error' : '' ; ?>">
            <button type="submit" class="btn btn-default">S'inscrire</button>
            <input type="hidden" name="from" value="register">
            <input type="hidden" name="success" value="login">
            <p>Tu es déjà inscrit ? <a href="login.php">Connecte toi</a></p>
        </form>
    </div>