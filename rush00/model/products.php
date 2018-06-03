<?php
require_once('mysqli.php');

function product_get_filter($cat, $max, $min, $name)
{
	$db = database_connect();
	$query = "SELECT * FROM products INNER JOIN products_has_categories
			ON products_has_categories.products_id = products.id
			WHERE 1 = 1";
	$name = mysqli_real_escape_string($db, $name);
	$cat = mysqli_real_escape_string($db, $cat);
	$min = mysqli_real_escape_string($db, $min);
	$max = mysqli_real_escape_string($db, $max);
	if ($name)
		$query .= " AND products.name LIKE '$name'";
	if ($cat)
		$query .= " AND products_has_categories.categories_id = '$cat'";
	if ($max)
		$query .= " AND products.price <= '$max'";
	if ($min)
		$query .= " And products.price >= '$min'"; 
	$ret = mysqli_query($db, $query);
	if ($ret)
		return mysqli_fetch_all($ret, MYSQLI_ASSOC);
	return ("product_get_filter: Fail to fetch");
}

function product_get_byid($id)
{
	$db = database_connect();
	$query = "SELECT * FROM products WHERE id = '$id'";
	$ret = mysqli_query($db, $query);
	if ($ret)
		$ret = mysqli_fetch_assoc($ret);
	return ($ret);
}

function products_get()
{
	$db = database_connect();
	$req = "SELECT * FROM products ORDER BY name ASC";
	$req = mysqli_query($db, $req);
	if (!$req)
		return null;
	return mysqli_fetch_all($req, MYSQLI_ASSOC);
}

function products_get_random(int $number)
{
	$db = database_connect();
	$req = "SELECT * FROM products ORDER BY name ASC";
	$req = mysqli_query($db, $req);
	if (!$req)
		return null;
	$ret = [];
	$arr = mysqli_fetch_all($req, MYSQLI_ASSOC);
	$keys = array_rand($arr, $number);
	foreach ($keys as $k)
	{
		$ret[] = $arr[$k];
	}
	return $ret;
}

function product_get_byname(string $name)
{
	$db = database_connect();
	$name = mysqli_real_escape_string($db, $name);
	$req = "SELECT * FROM products WHERE name = '$name'";
	$req = mysqli_query($db, $req);
	if ($req)
		$req = mysqli_fetch_assoc($req);
	return $req;
}

function stock_get_byid($id)
{
	$db = database_connect();
	$query = "SELECT * FROM products WHERE id = '$id'";
	$ret = mysqli_query($db, $query);
	if ($ret)
		$ret = mysqli_fetch_assoc($ret);
	return $ret['stock'];
}

function product_updatestock_byid(int $id, int $number)
{
	$db = database_connect();
	$query = "UPDATE products set stock = $stock WHERE id = '$id'";
	$req = mysqli_query($db, $query);
	return $req;
}

function product_create(string $name, string $picture = NULL, bool $isAdult = false, float $price, int $databaseid)
{
	$err = NULL;
	$db = database_connect();
	if (strlen($name) < 3 || strlen($name) > 100)
		$err[] = 'name';
	if ($picture != NULL && (strlen($picture) < 10 || strlen($picture) > 50))
		$err[] = 'picture';
	if ($price < 0)
		$err[] = 'price';
	if ($err !== NULL)
		return ($err);
	$name = mysqli_real_escape_string($db, $name);
	$picture = mysqli_real_escape_string($db, $picture);
	$isAdult = $isAdult ? 1 : 0;
	$req = "INSERT INTO products (name, picture, isAdult, price, databaseid) VALUES('$name', '$picture', '$isAdult', '$price', '$databaseid')";
	$req = mysqli_query($db, $req);
	if ($req)
		return true;
	return array('error');
}

function product_delete(string $name)
{
	$db = database_connect();
	$name = mysqli_real_escape_string($db, $name);
	$req = "DELETE FROM products WHERE name = '$name'";
	$req = mysqli_query($db, $req);
	if ($req)
		return true;
	return $req;
}

function product_clear(string $name)
{
	$db = database_connect();
	$name = mysqli_real_escape_string($db, $name);
	$req = "UPDATE products set (name, price, databaseid, stock, isAdult, picture) VALUES
	('', 0, 0, 0, 0, '') WHERE name = '$name'";
	$req = mysqli_query($db, $req);
	if ($req)
		$req = mysqli_fetch_assoc($req);
	return $req;
}

function product_clear_byid(int $id)
{
	$db = database_connect();
	$req = "UPDATE products set (name, price, databaseid, stock, isAdult, picture) VALUES
	('', 0, 0, 0, 0, '') WHERE id = '$id'";
	$req = mysqli_query($db, $req);
	if ($req)
		$req = mysqli_fetch_assoc($req);
	return $req;
}

function product_update(string $name, string $picture = NULL, bool $isAdult, float $price, int $databaseid, $stock, $id)
{
	$err = NULL;
	$db = database_connect();
	if (strlen($name) < 3 || strlen($name) > 100)
		$err[] = 'name';
	if ($picture != NULL && (strlen($picture) < 10 || strlen($picture) > 50))
		$err[] = 'picture';
	if ($price < 0)
		$err[] = 'price';
	if ($stock < 0)
		$err[] = 'stock';
	if ($err !== NULL)
		return ($err);
	$name = mysqli_real_escape_string($db, $name);
	$picture = mysqli_real_escape_string($db, $picture);
	$stock = mysqli_real_escape_string($db, $stock);
	$req = "UPDATE products SET name='$name', picture='$picture', isAdult='0', price='$price', databaseid='$databaseid', stock='$stock' WHERE id = '$id'";
	$req = mysqli_query($db, $req);
	if ($req)
		return true;
	return ('update error');
}

function clear_basket()
{
$_SESSION['basketMovie'] = null;
$_SESSION['basketPrice'] = null;
$_SESSION['basketCount'] = null;
}
?>
