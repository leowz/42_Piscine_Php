<?php
session_start();
require_once('model/products.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['id'])
{
	$movies = product_get_byid($_POST['id']);
	if ($_POST['quantity'] && is_numeric($_POST['quantity']) &&
		$_POST['quantity'] > 0 && $movies)
	{
		$basket = unserialize($_SESSION['basketMovie']);
		if ($basket[$_POST['id']]) 
		{
			$basket[$_POST['id']] += $_POST['quantity'];
			$_SESSION['basketCount'] += $_POST['quantity'];
			$_SESSION['basketPrice'] += $movies['price'] * $_POST['quantity'];
		}
		else
		{
			$basket[$_POST['id']] = $_POST['quantity'];
			$_SESSION['basketCount'] += $_POST['quantity'];
			$_SESSION['basketPrice'] += $movies['price'] * $_POST['quantity'];
		}
		$_SESSION['basketMovie'] = serialize($basket);
	}
	else
	{
		header('Location: movie.php?id=' . $_POST['id']);
		exit();
	}
}

if ($_GET['remove'] == '1') {
	clear_basket();
}

$basket = unserialize($_SESSION['basketMovie']);

include('partial/header.php');
?>

	<div class="row error">
    <?php
        foreach ($_GET as $k => $v) {
			if ($k !== 'remove')
				echo '<div>'.$k.' : '.$v.'</div><br />';
        }
    ?>
    </div>

<div class="container">
    <h1 style="text-align: left">My Cart</h1>
    <?php
        if ($basket) {
            ?>
            <table class="basket">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Poster</td>
                    <td>Name</td>
                    <td class="right">Price</td>
                    <td class="right">Quntity</td>
                    <td class="right">To Pay</td>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($basket as $k => $v) {
                        $movies = product_get_byid($k);
                        ?>
                        <tr>
                            <td><a href="movie.php?id=<?php echo $k; ?>"><?php echo $k; ?></a></td>
                            <td><a href="movie.php?id=<?php echo $k; ?>"><img
                                        src="http://image.tmdb.org/t/p/w185/<?php echo $movies['picture']; ?>"
                                        alt=""></a>
                            </td>
                            <td class="title"><a
                                    href="movie.php?id=<?php echo $k; ?>"><?php echo $movies['name']; ?></a>
                            </td>
                            <td class="right"><?php echo number_format($movies['price'], 2); ?> €</td>
                            <td class="right"><?php echo $v ?></td>
                            <td class="right"><?php echo number_format($movies['price'] * $v, 2); ?> €</td>
                        </tr>
						<?php
					}
						?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5"></td>
                    <td class="right"><?php echo isset($_SESSION['basketPrice']) ? $_SESSION['basketPrice'] : '0.00'; ?>
                        €
                    </td>
                </tr>
                </tfoot>
			</table>
			<div class="row">
                <div class="col-l-6">
                    <a href='basket.php?remove=1' class='button'>Remove all items</a>
                </div>
                <div class="col-l-6">
                    <?php
                        if ($_SESSION['email']) {
                            echo "<form method=\"post\" action=\"controller/orders.php\" />
                            <input type=\"hidden\" name=\"from\" value=\"basket\" />
                            <input type=\"hidden\" name=\"success\" value=\"member\" />
                            <input type=\"submit\" class='button' value='Validate the command'/></form>";
						}
						else
						{
                            echo "<a href='login.php' class='button'>Connect to your account</a>";
                        }
                    ?></div>
            </div>
            <?php
			}
			else
			{
				echo "<h4>There is nothing in thier cart</h4>";
			}
    	?>
</div>
</div>
<?php include('partial/footer.php'); ?>
