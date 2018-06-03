<?php
session_start();

require_once ('model/people.php');
require_once ('model/categories.php');
require_once ('model/products.php');
require_once ('model/orders.php');

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
	header('Location: index.php');
	exit();
}

$people = admin_exist($_SESSION['email']);
if ($people === null) {
	header('Location: index.php');
	exit();
}

$peoples = people_get_all();
$categories = category_get_all();
$products = products_get();
$orders	= order_get_all();

include('partial/header.php');
?>
<div class="container">
	<div class="row error">
    <?php
        foreach ($_GET as $k => $v) {
            echo '<div>'.$k.' : '.$v.'</div>';
        }
    ?>
    </div>
    <div class="row">
        <div class="col-l-6 padding">
            <h2>User</h2>
            <h5>Add User:</h5>
            <form action="controller/admin.php" method="POST">
                <input type="password" name="passwd" placeholder="password">
                <input type="email" name="email" placeholder="email">
                <input type="text" name="fname" placeholder="first name">
                <input type="text" name="lname" placeholder="last name">
                <input type="text" name="address" placeholder="adresse">
                <input type="hidden" name="from" value="user_create_byAdmin">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit" class="btn btn-default">add</button>
            </form>
            <h5>Remove User:</h5>
            <form action="controller/admin.php" method="POST">
                <select name="email">
                    <?php
                        foreach($peoples as $v) {
                            echo "<option value='".$v['email']."'>".$v['email']." - ".$v['firstname']." ".$v['lastname']."</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="from" value="user_delete_byAdmin">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
				<button type="submit" class="btn btn-default">remove</button>
            </form>
            <h5>Update User:</h5>
            <form action="controller/people.php" method="POST">
                <select name="email">
                    <?php
                        foreach($peoples as $v) {
                            echo "<option value='".$v['email']."'>".$v['email']." - ".$v['firstname']." ".$v['lastname']."</option>";
                        }
                    ?>
                </select>
                <input type="password" name="password" placeholder="password">
                <input type="text" name="firstname" placeholder="first name">
                <input type="text" name="lastname" placeholder="last name">
                <input type="text" name="address" placeholder="adresse">
                <input type="hidden" name="from" value="update">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit" class="btn btn-default">save</button>
            </form>
        </div>
        <div class="col-l-6 padding">
            <h2>Categories</h2>
            <h5>Add Categories:</h5>
            <form action="controller/categories.php" method="POST">
                <input type="text" name="name">
                <input type="hidden" name="from" value="addcategorie">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">add</button>
            </form>
            <h5>Delete Categories:</h5>
            <form action="controller/categories.php" method="POST">
                <select name="name">
                    <?php
                        foreach($categories as $v) {
                            echo "<option value='".$v['name']."'>".$v['name']."</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="from" value="removecategory">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">delete</button>
            </form>
            <h5>Update Categories:</h5>
            <form action="controller/categories.php" method="POST">
                <select name="oldname">
                    <?php
                        foreach($categories as $v) {
                            echo "<option value='".$v['name']."'>".$v['name']."</option>";
                        }
                    ?>
                </select>
                <input type="text" name="name" placeholder="nouveau nom">
                <input type="hidden" name="from" value="updatecategorie">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">save</button>
            </form>
        </div>
        <div class="col-l-6 padding">
            <h2>Film</h2>
            <h5>Add Film:</h5>
            <form action="controller/products.php" method="POST">
                <input type="text" name="name" placeholder="file name">
                <input type="number" name="databaseid" placeholder="ID or api">
                <input type="number" name="price" placeholder="Price">
                <input type="number" name="stock" placeholder="stock quantity">
                <input type="hidden" name="isAdult" value="0">
                <input type="hidden" name="from" value="addproduct">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">add</button>
            </form>
            <h5>Delete Film</h5>
            <form action="controller/products.php" method="POST">
                <select name="name">
                    <?php
                        foreach($products as $v) {
                            echo "<option value='".$v['name']."'>".$v['name']."</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="from" value="removeproduct">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">delete</button>
            </form>
            <h5>Update Film</h5>
            <form action="controller/products.php" method="POST">
                <select name="id">
                    <?php
                        foreach($products as $v) {
                            echo "<option value='".$v['id']."'>".$v['name']."</option>";
                        }
                    ?>
                </select>
                <input type="text" name="name" placeholder="file new name">
                <input type="number" name="databaseid" placeholder="ID api">
                <input type="number" name="price" placeholder="new price">
                <input type="number" name="stock" placeholder="new stock">
                <input type="hidden" name="isAdult" value="0">
                <input type="hidden" name="from" value="updateproduct">
                <input type="hidden" name="success" value="admin">
                <button type="submit" class="btn btn-default">save</button>
            </form>
        </div>
		<div class="col-l-6 padding">
            <h2>Orders</h2>
            <h5>Create new order</h5>
            <form action="controller/orders.php" method="POST">
                <select name="email">
                    <?php
                        foreach($peoples as $v) {
                            echo "<option value='".$v['email']."'>".$v['email']." - ".$v['firstname']." ".$v['lastname']."</option>";
                        }
                    ?>
						<option value=<?php echo $_SESSION['email']?>><?php echo $_SESSION['email']?> - Me</option>
                </select>
                <select name="product_id">
                    <?php
                        foreach($products as $v) {
                            echo "<option value='".$v['id']."'>".$v['name']."</option>";
                        }
                    ?>
                </select>
                <input type="number" name="quantity" placeholder="quantity">
                <input type="hidden" name="from" value="addAnOrder">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit" class="btn btn-default">create</button>
            </form>
            <h5>Delete order</h5>
            <form action="controller/orders.php" method="POST">
                <select name="order+product">
                    <?php
                        foreach($orders as $o) {
                            echo "<option value='".$o['orders_id'].";".$o['products_id']."'>"."order id:".$o['orders_id'].' - prod id:'.$o['products_id'].' - quantity: '.$o['quantity']."</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="from" value="removeAnOrder">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit" class="btn btn-default">delete</button>
            </form>
            <h5>Update order</h5>
            <form action="controller/orders.php" method="POST">
                <select name="order+product">
                    <?php
                        foreach($orders as $o) {
                            echo "<option value='".$o['orders_id'].";".$o['products_id']."'>"."order id:".$o['orders_id'].' - prod id:'.$o['products_id'].' - quantity: '.$o['quantity']."</option>";
                        }
                    ?>
                </select>
                <input type="number" name="quantity" placeholder="new quantity">
                <input type="hidden" name="from" value="updateAnOrder">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit" class="btn btn-default">save</button>
            </form>
        </div>

    </div>
</div>
<?php include('partial/footer.php')?>
