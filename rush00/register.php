<?php
session_start();

if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
	header('Location: index.php');
	exit();
}
include_once('partial/header.php');
?>
<div>
        <h1>register</h1>
        <form action="controller/people.php" method="POST">
			<input type="text" placeholder="fist name" name=fname value="">
			<input type="text" placeholder="last name" name=lname value="">
			<input type="password" placeholder="passwd(*)" name=passwd value="">
			<input type="email" placeholder="email(*)" name=email value="">
			<input type="submit" value="register">
			<input type="hidden" name=from value="register">
        </form>
</div>
