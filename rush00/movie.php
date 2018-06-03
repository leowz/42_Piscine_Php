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
	<div class="movie_info">
        <div class="movie_img">
            <img src="http://image.tmdb.org/t/p/w185/<?php echo $product['picture']; ?>" alt="">
        </div>
        <div class="info">
            <dl>
                <dt class="title">Release Date</dt>
                <dd><?php echo isset($movie['release_date']) ? $movie['release_date'] : 'unknown' ; ?></dd>
                <dt class="title">Original language</dt>
                <dd><?php echo isset($movie['original_language']) ? $movie['original_language'] : 'unknown' ; ?></dd>
                <dt class="title">Title Original</dt>
                <dd><?php echo isset($movie['original_title']) ? $movie['original_title'] : 'unknown' ; ?></dd>
                <dt class="title">Budget</dt>
                <dd><?php echo isset($movie['budget']) ? $movie['budget'].' $' : 'unknown' ; ?></dd>
                <dt class="title">Revenue</dt>
                <dd><?php echo isset($movie['revenue']) ? $movie['revenue'].' $' : 'unknown' ; ?></dd>
                <dt class="title">Production companies</dt>
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
        <?php
			echo "\n";
            if (isset($credits['cast'])) {
				$count = 0;
				echo "<div class='movie_collection'>";
                foreach ($credits['cast'] as $v) {
                    $v = (array)$v;
					$count++;
					if ($count > 20)
						break;
                    if (!empty($v['profile_path']))
					{
						?>
                        <div class="movie_box">
							<img class="movie" src=<?php echo 'http://image.tmdb.org/t/p/w185/'.$v['profile_path'];?> alt="image">
							<div class="title"><?php echo $v['name'];?> as <?php echo $v['character'];?></div>
                        </div>
				<?php
					}
                }
				echo "</div>";
            }
        ?>
    <h3>Crew</h3>
        <?php
            if (isset($credits['crew'])) {
				$count = 0;
				echo "<div class='movie_collection'>";
                foreach ($credits['crew'] as $v) {
                    $v = (array)$v;
					$count++;
					if ($count > 15)
						break;
                    if (!empty($v['profile_path']))
					{
					?>
                    <div class="movie_box">
                   		<div class="title">
						<img class="movie" src=<?php echo 'http://image.tmdb.org/t/p/w185/'.$v['profile_path'];?> alt="image">
						<div class="title"><?php echo $v['name'];?> as <?php echo $v['job'];?></div>
                    	</div>
                    </div>
				<?php
					}
                }
				echo "</div>";
            }
        ?>
    </div>
</div>

<?php
include_once('partial/footer.php');
?>
