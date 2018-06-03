<?php
session_start();

    require_once('model/people.php');
    require_once('model/orders.php');
    require_once('model/prod.php');
    require_once('model/products.php');


    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
		error_log("pseudo not exist");
        header('Location: index.php');
        exit();
    }

    $people = people_exist($_SESSION['email']);
    if ($people === null) {
		error_log("people not exist");
        header('Location: index.php');
        exit();
    }

    $orders = order_get_bypid($people['id']);

    include('partial/header.php');
?>
<div class="container">
    <div class="row">
        <div class="col-l-6">
            <h2>My Settings</h2>
            <form action="controller/people.php" method="POST">
                <input type="password" name="password" placeholder="change password" value=""
                       class="<?php echo isset($_GET['password']) ? 'error' : ''; ?>">
                <input type="text" name="firstname" placeholder="First Name" value="<?php echo $people['firstname']; ?>"
                       class="<?php echo isset($_GET['firstname']) ? 'error' : ''; ?>">
                <input type="text" name="lastname" placeholder="Last Name" value="<?php echo $people['lastname']; ?>"
                       class="<?php echo isset($_GET['lastname']) ? 'error' : ''; ?>">
                <input type="text" name="address" placeholder="Address" value="<?php echo $people['address']; ?>"
                       class="<?php echo isset($_GET['address']) ? 'error' : ''; ?>">
                <button type="submit" class="btn btn-default">Save</button>
                <input type="hidden" name="success" value="member">
                <input type="hidden" name="from" value="update">
                <input type="hidden" name="error" value="member">
            </form>
        </div>
        <div class="col-l-6">
            <h2>My Commands</h2>
            <?php
                if ($orders) {
                        echo "<h5>commande of " . $orders['date_order'] . "</h5>";
                        ?>
                        <table class="basket">
                            <tbody>
                            <?php
                                $products = prod_get_byord(intval($orders['id']));
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
                    echo "</div>";
                }
				else
				{
					echo "<p>You do not have any command</p>";
				}
            ?>
        </div>
		<?php
	if (!$_SESSION['admin'] || $_SESSION['admin'] != 1)
	{
		?>
		<div>
			<h2>Delete Account</h2>
				<p>
				warning: the deletion operation is inreversable and might have serious consequences!
				Think twice before doing this!
				</p>
            <form action="controller/people.php" method="POST">
                <button type="submit" style="background-color:#F26B5C;">Delete this account forever!</button>
                <input type="hidden" name="success" value="index">
                <input type="hidden" name="from" value="delete_self">
                <input type="hidden" name="error" value="member">
            </form>
		</div>
		<?php 
		}
		?>
    </div>
</div>
<?php include('partial/footer.php');?>
