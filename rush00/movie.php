<?php
session_start();
require_once('model/products.php');
include_once('partial/header.php');

$product = product_get_byid($_GET['id']);
if (!$product)
{
	echo "no product";
	header('Location: browse.php');
	exit();
}

$movie = (array) json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$product['databaseid'].'?api_key=db663b344723dd2d6781aed1e2f7764d'));
$credits = (array) json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$product['databaseid'].'/credits?api_key=db663b344723dd2d6781aed1e2f7764d'));
?>

<div class="movie_container">
<h1><?php echo $product['name']; ?></h1>
	<div class="movie">
        <div class="movie_img">
            <img src="http://image.tmdb.org/t/p/w185/<?php echo $product['picture']; ?>" alt="">
        </div>
        <div class="col-l-8">
            <dl>
                <dt>Realise Date</dt>
                <dd><?php echo isset($movie['release_date']) ? $movie['release_date'] : 'unknown' ; ?></dd>
                <dt>Original Language</dt>
                <dd><?php echo isset($movie['original_language']) ? $movie['original_language'] : 'unknown' ; ?></dd>
                <dt>Title Original</dt>
                <dd><?php echo isset($movie['original_title']) ? $movie['original_title'] : 'unknown' ; ?></dd>
                <dt>Type</dt>
                <dd>test, test, test, test</dd>
                <dt>Budget</dt>
                <dd><?php echo isset($movie['budget']) ? $movie['budget'].' $' : 'unknown' ; ?></dd>
                <dt>Revenu</dt>
                <dd><?php echo isset($movie['revenue']) ? $movie['revenue'].' $' : 'unknown' ; ?></dd>
                <dt>Production Companies</dt>
                <dd><?php
                        if (isset($movie['production_companies'])) {
                            foreach ($movie['production_companies'] as $v) {
                                $v = (array)$v;
                                echo $v['name'].', ';
                            }
                        }
                    ?>
                </dd>
                <dt>Production Conuntries</dt>
                <dd><?php
                        if (isset($movie['production_countries'])) {
                            foreach ($movie['production_countries'] as $v) {
                                $v = (array)$v;
                                echo $v['name'].', ';
                            }
                        }
                    ?>
                </dd>
                <dt>Overview</dt>
                <dd><?php echo isset($movie['overview']) ? $movie['overview'] : 'unknown' ; ?></dd>
            </dl>
            <div class="addBasket">
                <form action="basket.php" method="post">
                    <input type="number" name="quantity" value="1">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
    <h3>Cast</h3>
	<div class="movie_collection">
        <?php
			echo "\n";
            if (isset($credits['cast'])) {
                foreach ($credits['cast'] as $v) {
                    $v = (array)$v;
                    echo '<div class="">';
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
    <h3>Crew</h3>
    <div class="movie_collection">

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

<?php
include_once('partial/footer.php');
?>
