<?php
session_start();
include_once('partial/header.php');
include_once('model/products.php');
include_once('model/people.php');

$movie = products_get_random(15);
?>
<div class="index_container">
	<?php
		if ($_SESSION['email'] && ($name = people_get_name($_SESSION['email'])))
		{
	?>
		<h1>Hello <?php echo $name?></h1>
		<?php
	}
	else
	{
	?>
	<h3><a href="login.php">Want to buy movies? Sign in right now!</a></h3>
	<?php }?>
	<h3>Some movies you might like:<a style='font-size:12px' href="index.php">Refresh movies</a></h3>
	<div class="movie_collection">
		<?php
		foreach ($movie as $v)
		{
		?>
		<a href="movie.php?id=<?php echo $v['id']; ?>">
			<div class="movie_box">
			  <img src="http://image.tmdb.org/t/p/w185/<?php echo $v['picture']; ?>">
			  <div class="title"><?php echo $v['name']; ?></div>
			  <div class="price"><?php echo number_format($v['price'], 2); ?> ‎€</div>
			</div>
		</a>
	<?php
		}
		?>
	</div>
</div>
<?php
include_once('partial/footer.php');
?>
