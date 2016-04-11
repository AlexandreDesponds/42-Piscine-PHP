<?php
    session_start();

    require_once ('model/people.php');
    require_once ('model/categories.php');
    require_once ('model/products.php');

    if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
        header('Location: index.php');
        exit();
    }

    $people = admin_exist($_SESSION['admin']);
    if ($people === null) {
        header('Location: index.php');
        exit();
    }
    
    $peoples = people_get_all();
    $categories = category_get_all();
    $products = products_get();

    include('partial/header.php');
?>
<div class="container">
    <div class="row error">
    <?php
        foreach ($_GET as $k => $v) {
            echo '<div>'.$k.' : '.$v.'</div>';
        }
    ?>
    </div>
    <div class="row">
        <div class="col-l-6 padding">
            <h2>Utilisateur</h2>
            <h5>Ajouter</h5>
            <form action="controller/people.php" method="POST">
                <input type="text" name="pseudo" placeholder="pseudo">
                <input type="password" name="password" placeholder="password">
                <input type="email" name="email" placeholder="email">
                <input type="text" name="firstname" placeholder="prénom">
                <input type="text" name="lastname" placeholder="nom">
                <input type="text" name="address" placeholder="adresse">
                <input type="hidden" name="from" value="register">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit" class="btn btn-default">Ajouter</button>
            </form>
            <h5>Supprimer</h5>
            <form action="controller/people.php" method="POST">
                <select name="pseudo">
                    <?php
                        foreach($peoples as $v) {
                            echo "<option value='".$v['pseudo']."'>".$v['pseudo']." - ".$v['firstname']." ".$v['lastname']."</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="from" value="unregister">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit" class="btn btn-default">Supprimer</button>
            </form>
            <h5>Modifier</h5>
            <form action="controller/people.php" method="POST">
                <select name="pseudo">
                    <?php
                        foreach($peoples as $v) {
                            echo "<option value='".$v['pseudo']."'>".$v['pseudo']." - ".$v['firstname']." ".$v['lastname']."</option>";
                        }
                    ?>
                </select>
                <input type="password" name="password" placeholder="password">
                <input type="text" name="firstname" placeholder="prénom">
                <input type="text" name="lastname" placeholder="nom">
                <input type="text" name="address" placeholder="adresse">
                <input type="hidden" name="from" value="update">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit" class="btn btn-default">Ajouter</button>
            </form>
        </div>
        <div class="col-l-6 padding">
            <h2>Catégories</h2>
            <h5>Ajouter</h5>
            <form action="controller/categories.php" method="POST">
                <input type="text" name="name">
                <input type="hidden" name="from" value="addcategorie">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">Ajouter</button>
            </form>
            <h5>Supprimer</h5>
            <form action="controller/categories.php" method="POST">
                <select name="name">
                    <?php
                        foreach($categories as $v) {
                            echo "<option value='".$v['name']."'>".$v['name']."</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="from" value="removecategory">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">Supprimer</button>
            </form>
            <h5>Modifier</h5>
            <form action="controller/categories.php" method="POST">
                <select name="oldname">
                    <?php
                        foreach($categories as $v) {
                            echo "<option value='".$v['name']."'>".$v['name']."</option>";
                        }
                    ?>
                </select>
                <input type="text" name="name" placeholder="nouveau nom">
                <input type="hidden" name="from" value="updatecategorie">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">Supprimer</button>
            </form>
        </div>
        <div class="col-l-6 padding">
            <h2>Films</h2>
            <h5>Ajouter</h5>
            <form action="controller/products.php" method="POST">
                <input type="text" name="name" placeholder="titre du film">
                <input type="number" name="databaseid" placeholder="ID api">
                <input type="number" name="price" placeholder="Prix">
                <input type="number" name="stock" placeholder="stock">
                <input type="hidden" name="isAdult" value="0">
                <input type="hidden" name="from" value="addproduct">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">Ajouter</button>
            </form>
            <h5>Supprimer</h5>
            <form action="controller/products.php" method="POST">
                <select name="name">
                    <?php
                        foreach($products as $v) {
                            echo "<option value='".$v['name']."'>".$v['name']."</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="from" value="removeproduct">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">Supprimer</button>
            </form>
            <h5>Modifier</h5>
            <form action="controller/products.php" method="POST">
                <select name="id">
                    <?php
                        foreach($products as $v) {
                            echo "<option value='".$v['id']."'>".$v['name']."</option>";
                        }
                    ?>
                </select>
                <input type="text" name="name" placeholder="titre du film">
                <input type="number" name="databaseid" placeholder="ID api">
                <input type="number" name="price" placeholder="Prix">
                <input type="number" name="stock" placeholder="stock">
                <input type="hidden" name="isAdult" value="0">
                <input type="hidden" name="from" value="updateproduct">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">Ajouter</button>
            </form>
        </div>
    </div>
</div>
