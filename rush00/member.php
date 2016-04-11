<?php
    session_start();

    require_once('model/people.php');
    require_once('model/orders.php');
    require_once('model/ord_has_prod.php');
    require_once('model/products.php');


    if (!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo'])) {
        header('Location: index.php');
        exit();
    }

    $people = people_exist($_SESSION['pseudo']);
    if ($people === null) {
        header('Location: index.php');
        exit();
    }

    $orders = order_get_bypeopleid($people['id']);

    include('partial/header.php');
?>
<div class="container">
    <div class="row">
        <div class="col-l-6">
            <h2>Modifier mes informations</h2>
            <form action="controller/people.php" method="POST">
                <input type="password" name="password" placeholder="Ton nouveau mot de passe" value=""
                       class="<?php echo isset($_GET['password']) ? 'error' : ''; ?>">
                <input type="text" name="firstname" placeholder="Ton prenom" value="<?php echo $people['firstname']; ?>"
                       class="<?php echo isset($_GET['firstname']) ? 'error' : ''; ?>">
                <input type="text" name="lastname" placeholder="Ton nom" value="<?php echo $people['lastname']; ?>"
                       class="<?php echo isset($_GET['lastname']) ? 'error' : ''; ?>">
                <input type="text" name="address" placeholder="Ton adresse" value="<?php echo $people['address']; ?>"
                       class="<?php echo isset($_GET['address']) ? 'error' : ''; ?>">
                <button type="submit" class="btn btn-default">Modifier</button>
                <input type="hidden" name="success" value="member">
                <input type="hidden" name="from" value="update">
                <input type="hidden" name="error" value="member">
            </form>
        </div>
        <div class="col-l-6">
            <h2>Mes commandes</h2>
            <?php
                if ($orders) {
                    foreach ($orders as $o) {
                        echo "<h5>commande du " . $o['date_order'] . "</h5>";
                        ?>
                        <table class="basket">
                            <tbody>
                            <?php
                                $products = prod_get_byord(intval($o['orders_id']));
                                foreach ($products as $p2) {
                                    $p = product_get_byid($p2['products_id']);
                                    ?>
                                    <tr>
                                        <td><a href="movie.php?id=<?php echo $p['id']; ?>"><?php echo $p['id']; ?></a>
                                        </td>
                                        <td class="title"><a
                                                href="movie.php?id=<?php echo $p['id']; ?>"><?php echo $p['name']; ?></a>
                                        </td>
                                        <td class="right"><?php echo number_format($p2['quantity'], 0); ?></td>
                                        <td class="right"><?php echo number_format($p2['price'] * $p2['quantity'], 2); ?> €</td>
                                    </tr>
                                    <?php
                                }

                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>
