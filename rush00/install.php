<?php
	require_once('model/products.php');
	require_once('model/categories.php');
	require_once('model/prod.php');
	require_once('model/mysqli.php');
	require_once('model/people.php');

$movie_quantity = 100;

// delete rush if exist
$db = database_connect2();
$sql = "DROP DATABASE `rush`;";
$req = mysqli_query($db, $sql);

if (mysqli_error($db))
	var_dump(mysqli_error($db));

// create db
$sql = "CREATE DATABASE `rush`;";
$req = mysqli_query($db, $sql);


if (mysqli_error($db))
	var_dump(mysqli_error($db));

// creat table
$db = database_connect();
$sql = "CREATE DATABASE `rush`;";
$req = mysqli_query($db, $sql);

// config database
$db = database_connect();
$sql = "SET FOREIGN_KEY_CHECKS=0;";
$req = mysqli_query($db, $sql);

// create tables
$sql = "CREATE TABLE `categories`(
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(45) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;";
$req = mysqli_query($db, $sql);
if (mysqli_error($db))
	var_dump(mysqli_error($db));
else
	echo "category table created\n";

$sql = "CREATE TABLE `orders` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`date_order` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`peoples_id` int(10) unsigned NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id_UNIQUE` (`id`),
KEY `fk_orders_peoples1_idx` (`peoples_id`),
CONSTRAINT `fk_orders_peoples1` FOREIGN KEY (`peoples_id`) REFERENCES `peoples` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";
$req = mysqli_query($db, $sql);
if (mysqli_error($db))
	var_dump(mysqli_error($db));
else
	echo "order table created\n";

$sql = "CREATE TABLE `orders_has_products` (
`orders_id` int(10) unsigned NOT NULL,
`products_id` int(10) unsigned NOT NULL,
`price` double unsigned NOT NULL,
`quantity` int(10) unsigned NOT NULL,
PRIMARY KEY (`orders_id`,`products_id`),
KEY `fk_orders_has_products_products1_idx` (`products_id`),
KEY `fk_orders_has_products_orders1_idx` (`orders_id`),
CONSTRAINT `fk_orders_has_products_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `fk_orders_has_products_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$req = mysqli_query($db, $sql);
if (mysqli_error($db))
	var_dump(mysqli_error($db));

$sql = "CREATE TABLE `peoples` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`pseudo` varchar(45) NOT NULL,
`email` varchar(255) NOT NULL,
`password` varchar(100) NOT NULL,
`isAdmin` tinyint(1) DEFAULT '0',
`firstname` varchar(45) NOT NULL,
`lastname` varchar(45) NOT NULL,
`address` varchar(100) NOT NULL,
`cookie` varchar(100) DEFAULT NULL,
`valid` varchar(45) DEFAULT NULL COMMENT 'empty if user is valid\nfilled with a key if user have to get registered',
PRIMARY KEY (`id`),
UNIQUE KEY `id_UNIQUE` (`id`),
UNIQUE KEY `pseudo_UNIQUE` (`pseudo`),
UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;";
$req = mysqli_query($db, $sql);
if (mysqli_error($db))
	var_dump(mysqli_error($db));
else
	echo "people table created\n";

$sql = "CREATE TABLE `products` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`price` double unsigned NOT NULL,
`databaseid` int(10) unsigned NOT NULL,
`isAdult` tinyint(1) DEFAULT '0',
`picture` varchar(50) DEFAULT NULL,
`stock` int(10) unsigned DEFAULT 10,
PRIMARY KEY (`id`),
UNIQUE KEY `id_UNIQUE` (`id`),
UNIQUE KEY `databaseid_UNIQUE` (`databaseid`)
) ENGINE=InnoDB AUTO_INCREMENT=3677 DEFAULT CHARSET=utf8;";
$req = mysqli_query($db, $sql);
if (mysqli_error($db))
	var_dump(mysqli_error($db));
else
	echo "product table created\n";


$sql = "CREATE TABLE `products_has_categories` (
`products_id` int(10) unsigned NOT NULL,
`categories_id` int(10) unsigned NOT NULL,
PRIMARY KEY (`products_id`,`categories_id`),
KEY `fk_products_has_categories_categories1_idx` (`categories_id`),
KEY `fk_products_has_categories_products_idx` (`products_id`),
CONSTRAINT `fk_products_has_categories_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `fk_products_has_categories_products` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$req = mysqli_query($db, $sql);
if (mysqli_error($db))
	var_dump(mysqli_error($db));

// connect to db and auth
$db = database_connect();
$req = mysqli_query($db, $req);
$api_key = '?api_key=9516bcc3f6518e2454476a43925c4625';
$request_base = 'http://api.themoviedb.org/3/movie/';
$time = microtime(TRUE);
echo "all connect, megrating data base\n";

//config
$start = 500;
$max = $start + $movie_quantity;

// start megrating
for ($i = $start; $i < $max; $i++)
{
	$price = (float)(mt_rand(80, 260) / 10);
	//@ silence any error raiseb by the function
	$a = @file_get_contents($request_base . $i . $api_key);
	if ($a)
		$data = (array)json_decode($a);
	else
	{
		$max++;
	$data = NULL;
	}
	if ($data)
	{
		if (isset($data['status_code']) && $data['status_code'] != 1)
			echo 'The API returned an error :' . $data['status_message'] . '\n';
		else
		{
			$genre = ((array)((array)($data['genres'])[0]))['name'];
			$price = (mt_rand(80, 300) / 10);
			if ($genre && !category_get($genre))
			{
				category_create($genre);
			}
			if (!$data['adult'])
				$data['adult'] = 0;
			else
				$data['adult'] = 1;
			$ret = product_create($data['original_title'], $data['poster_path'], $data['adult'], $price, $i);
			if ($ret === TRUE && $genre)
			{
				$cat = category_get($genre);
				if ($cat)
				{
					echo "capture category :".$cat."\n";
					$prod = product_get_byname($data['original_title']);
					category_add_toprod($cat['id'], $prod['id']);
				}
				echo "Successfully imported ".$data['original_title']." \n";
			}
			else
			{
				var_dump(mysqli_error($db));
				echo "<br/><strong>Creation failed\n</strong> :" . $data['original_title'] . "<br />"; var_dump($ret);
			}
		}
	}
	if ($i % 40 == 0)
	{
		$wait = 1000 + $time - microtime(true);
		if ($wait > 0)
			usleep($wait);
		$time = microtime(TRUE);
	}
}

//
// create a super user
if (people_create("root@zweng", "123456", "root", "root", "", 1))
{
	var_dump(mysqli_error($db));
	echo "create admin fails, go to ip/adminRegister.php to create admin user\n";
}
else
	echo "create admin succes. email: root@zweng, password: 123456 \n";
?>

