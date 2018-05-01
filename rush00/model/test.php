<?php
require_once('mysqli.php');
require_once('hash.php');


function test()
{
	$db = database_connect();
	$passwd = $db->escape_string(hash_passwd('123456'));
	echo $passwd;
}

test();
?>
