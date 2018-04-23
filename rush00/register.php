<?php
session_start();
include_once('partial/header.php');
?>
<div>
        <h1>register</h1>
        <form action="controller/people.php" method="POST">
                <input type="text" placeholder="fname" name=fname value="">
                <input type="text" placeholder="lname" name=lname value="">
                <input type="password" placeholder="passwd" name=passwd value="">
                <input type="email" placeholder="email" name=email value="">
                <input type="submit" value="register">
                <input type="hidden" name=from value="register">
        </form>
</div>
