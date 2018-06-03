<?php
session_start();
include_once('model/categories.php');
include_once('model/products.php');
include_once('partial/header.php');

$categories = category_get_all();
$movie = product_get_filter($_GET['cat'], (float)$_GET['max'], (float)$_GET['min'], $_GET['name']);
error_log($movie);
?>
	<?php if (!empty($_GET))
	{
	?>
	<h4><a href="browse.php">reset all</a></h4>
	<?php
	}
	?>
<div>
	<div class="filter_section">
		<h2>Filter</h2>
		<form action="">
		<input type="text" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name']: "" ?>" placeholder="Title">
		<input type="number" name="min" value="<?php echo isset($_GET['min']) ? $_GET['min'] : "";?>" placeholder="Minimum price">
		<input type="number" name="max" value="<?php echo isset($_GET['max']) ? $_GET['max'] : "";?>" placeholder="Maximum prince">
		<input type="hidden" name="cat" value="<?php echo $_GET['cat']?>">
		<button type="submit">Search</button>
		</form>
		<h2>Category</h2>
		<ul class="category">
			<a class="categoryelem" href='browse.php'><li class="categoryelem">All</li></a>
			<?php
			foreach($categories as $c)
			{
				echo "<a class=\"categoryelem\" href='browse.php?cat=" . $c['id'] ."'><li class=\"categoryelem\"";
				echo ">" . $c['name'] . "</li></a>";
			}
			?>		
		</ul>
	</div>
	<div class="movie_collection">
			<?php
			foreach ($movie as $v)
			{
			?>
			<a href="movie.php?id=<?php echo $v['id']; ?>"><div class="movie_box">
				
				  <img class="movie" src="http://image.tmdb.org/t/p/w185/<?php echo $v['picture']; ?>">
				  <div class="title"><?php echo $v['name']; ?></div>
				  <div class="price"><?php echo number_format($v['price'], 2); ?> ‎€</div>
			</div></a>
			<?php
			}
			?>
		</div>
	<div>
	</div>
</div>
<?php include_once('partial/footer.php');?>
