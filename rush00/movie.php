<?php
    session_start();

    if (!$_GET['id'] || !is_numeric($_GET['id'])) {
        header('Location: browse.php');
        exit();
    }

    require_once ('model/products.php');

    $product = product_get_byid($_GET['id']);
    if (!$product) {
        header('Location: browse.php');
        exit();
    }

    $movie = (array) json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$product['databaseid'].'?api_key=db663b344723dd2d6781aed1e2f7764d'));
    $credits = (array) json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$product['databaseid'].'/credits?api_key=db663b344723dd2d6781aed1e2f7764d'));

    include('partial/header.php');
?>
<div class="container">
    <h1 style="text-align: left"><?php echo $product['name']; ?></h1>
    <div class="row movie">
        <div class="col-l-4 cover">
            <img src="http://image.tmdb.org/t/p/w185/<?php echo $product['picture']; ?>" alt="">
        </div>
        <div class="col-l-8">
            <dl>
                <dt>Date de sortie</dt>
                <dd><?php echo isset($movie['release_date']) ? $movie['release_date'] : 'inconnu' ; ?></dd>
                <dt>Langue d'origine</dt>
                <dd><?php echo isset($movie['original_language']) ? $movie['original_language'] : 'inconnu' ; ?></dd>
                <dt>Titre d'origine</dt>
                <dd><?php echo isset($movie['original_title']) ? $movie['original_title'] : 'inconnu' ; ?></dd>
                <dt>Genre</dt>
                <dd>test, test, test, test</dd>
                <dt>Budget</dt>
                <dd><?php echo isset($movie['budget']) ? $movie['budget'].' $' : 'inconnu' ; ?></dd>
                <dt>Revenu</dt>
                <dd><?php echo isset($movie['revenue']) ? $movie['revenue'].' $' : 'inconnu' ; ?></dd>
                <dt>Compagnie de production</dt>
                <dd><?php
                        if (isset($movie['production_companies'])) {
                            foreach ($movie['production_companies'] as $v) {
                                $v = (array)$v;
                                echo $v['name'].', ';
                            }
                        }
                    ?>
                </dd>
                <dt>Pays de production</dt>
                <dd><?php
                        if (isset($movie['production_countries'])) {
                            foreach ($movie['production_countries'] as $v) {
                                $v = (array)$v;
                                echo $v['name'].', ';
                            }
                        }
                    ?>
                </dd>
                <dt>Resumé</dt>
                <dd><?php echo isset($movie['overview']) ? $movie['overview'] : 'inconnu' ; ?></dd>
            </dl>
            <div class="addBasket">
                <form action="basket.php" method="post">
                    <input type="number" name="quantity" value="1">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn btn-default">Ajouter au panier</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <h3>Acteurs</h3>
        <?php
            if (isset($credits['cast'])) {
                foreach ($credits['cast'] as $v) {
                    $v = (array)$v;
                    echo '<div class="col-l-2 col-m-3 col-s-4">';
                    if (empty($v['profile_path']))
                        echo '<div class="actor" style="background-image: url(img/avatar.png)">';
                    else
                        echo '<div class="actor" style="background-image: url(http://image.tmdb.org/t/p/w185/'.$v['profile_path'].')">';
                            echo '<div class="title">';
                                echo '<p class="name">'.$v['name'].'</p>';
                                echo '<p>dans le rôle de</p>';
                                echo '<p class="role">'.$v['character'].'</p>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            }
        ?>
    </div>
    <div class="row">
        <h3>Equipes</h3>
        <?php
            if (isset($credits['crew'])) {
                foreach ($credits['crew'] as $v) {
                    $v = (array)$v;
                    echo '<div class="col-l-2 col-m-3 col-s-4">';
                    if (empty($v['profile_path']))
                        echo '<div class="actor" style="background-image: url(img/avatar.png)">';
                    else
                        echo '<div class="actor" style="background-image: url(http://image.tmdb.org/t/p/w185/'.$v['profile_path'].')">';
                    echo '<div class="title">';
                    echo '<p class="name">'.$v['name'].'</p>';
                    echo '<p>dans le rôle de</p>';
                    echo '<p class="role">'.$v['job'].'</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        ?>
    </div>
</div>
<?php include('partial/footer.php'); ?>
