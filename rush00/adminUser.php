<?php
    session_start();

    require_once ('model/people.php');

    if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
        header('Location: index.php');
        exit();
    }

    $admin = admin_exist($_SESSION['admin']);
    if ($admin === null) {
        header('Location: index.php');
        exit();
    }

    if ($_GET['id']) {
        $people = people_exist($_GET['id']);
        if (!$people) {
            header('Location: admin.php');
            exit();
        }
        include('partial/header.php');
        ?>
        <div class="container">
            <div class="row">
                <div class="col-l-12">
                    <h2>Modifier un utilisateur</h2>
                    <form action="controller/people.php" method="POST">
                        <input type="text" name="pseudo" placeholder="Ton email" value="<?php echo $people['pseudo']; ?>"
                               class="<?php echo isset($_GET['pseudo']) ? 'error' : ''; ?>">
                        <input type="password" name="password" placeholder="Ton mot de passe" value=""
                               class="<?php echo isset($_GET['password']) ? 'error' : ''; ?>">
                        <input type="email" name="email" placeholder="Ton email" value="<?php echo $people['email']; ?>"
                               class="<?php echo isset($_GET['email']) ? 'error' : ''; ?>">
                        <input type="text" name="firstname" placeholder="Ton prenom" value="<?php echo $people['firstname']; ?>"
                               class="<?php echo isset($_GET['firstname']) ? 'error' : ''; ?>">
                        <input type="text" name="lastname" placeholder="Ton nom" value="<?php echo $people['lastname']; ?>"
                               class="<?php echo isset($_GET['lastname']) ? 'error' : ''; ?>">
                        <input type="text" name="address" placeholder="Ton adresse" value="<?php echo $people['address']; ?>"
                               class="<?php echo isset($_GET['address']) ? 'error' : ''; ?>">
                        <button type="submit" class="btn btn-default">Modifier</button>
                        <input type="hidden" name="pseudoOld" value="<?php echo $people['pseudo']; ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="success" value="admin">
                        <input type="hidden" name="from" value="adminUser">
                    </form>
                </div>
            </div>
        </div>

        <?php
    } else {
        include('partial/header.php');
        ?>
        <div class="container">
            <div class="row">
                <div class="col-l-12">
                    <h2>Ajouter un utilisateur</h2>
                    <form action="controller/people.php" method="POST">
                        <input type="text" name="pseudo" placeholder="Ton email" value=""
                               class="<?php echo isset($_GET['pseudo']) ? 'error' : ''; ?>">
                        <input type="password" name="password" placeholder="Ton mot de passe" value=""
                               class="<?php echo isset($_GET['password']) ? 'error' : ''; ?>">
                        <input type="email" name="email" placeholder="Ton email" value=""
                               class="<?php echo isset($_GET['email']) ? 'error' : ''; ?>">
                        <input type="text" name="firstname" placeholder="Ton prenom" value=""
                               class="<?php echo isset($_GET['firstname']) ? 'error' : ''; ?>">
                        <input type="text" name="lastname" placeholder="Ton nom" value=""
                               class="<?php echo isset($_GET['lastname']) ? 'error' : ''; ?>">
                        <input type="text" name="address" placeholder="Ton adresse" value=""
                               class="<?php echo isset($_GET['address']) ? 'error' : ''; ?>">
                        <button type="submit" class="btn btn-default">Modifier</button>
                        <input type="hidden" name="action" value="create">
                        <input type="hidden" name="success" value="admin">
                        <input type="hidden" name="from" value="adminUser">
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
?>