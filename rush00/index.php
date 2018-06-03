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
	<h3><a href="login.php">Want to buy movies? Login right now!</a></h3>
	<?php }?>
	<h3><a href="index.php">refresh movies</a></h3>
	<div class="flex_container">
		<?php
		foreach ($movie as $v)
		{
		?>
		<div class="flex_item">
			<a href="movie.php?id=<?php echo $v['id']; ?>">
			  <img src="http://image.tmdb.org/t/p/w185/<?php echo $v['picture']; ?>">
			  <div class="price"><?php echo number_format($v['price'], 2); ?> ‎€</div>
			  <div class="title"><?php echo $v['name']; ?></div>
			  </a>
		</div>
	<?php
		}
		?>
	</div>
</div>
<?php
include_once('partial/footer.php');
?>
