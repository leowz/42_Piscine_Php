<?php
function hash_passwd($passwd)
{
	return (hash('sha256', $passwd));
}
?>
