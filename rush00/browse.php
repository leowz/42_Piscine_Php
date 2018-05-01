<?php
session_start();
include_once('model/categories.php');
include_once('model/products.php');
include_once('partial/header.php');

$categories = category_get_all();
$movie = product_get_filter($_GET['cat'], (float)$_GET['min'], (float)$_GET['max'], $_GET['name']);
?>

<div>
	<div class="filter_section">
		<h2>Filter</h2>
		<form action="">
		<input type="text" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name']: "" ?>" placeholder="name">
		<input type="number" name="min" value="<?php echo isset($_GET['min']) ? $_GET['min'] : "";?>" placeholder="min">
		<input type="number" name="max" value="<?php echo isset($_GET['max']) ? $_GET['max'] : "";?>" placeholder="max">
		<input type="hidden" name="cat" value="<?php echo $_GET['cat']?>">
		<button type="submit">Search</button>
		</form>
		<h2>Category</h2>
		<ul>
			<?php
			foreach($categories as $c)
			{
				echo "<a href='browse.php?cat=" . $c['id'] ."'><li";
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
			<div class="movie_box">
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
	<div>
	</div>
</div>
<?php include_once('partial/footer.php');?>
