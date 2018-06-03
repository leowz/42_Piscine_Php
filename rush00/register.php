<?php
session_start();

if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
	header('Location: index.php');
	exit();
}
include_once('partial/header.php');
?>
<div class="register_box">
        <h1>Register</h1>
		<?php
			if (!empty($_GET['err']))
			{
				echo "<h3>Register Error: ".$_GET['err']."</h3>";
			}
		?>
        <form action="controller/people.php" method="POST">
			<input type="text" placeholder="First name" name=fname value="" style="margin-left:1px;margin-right: 1px;width:175px;">
			<input type="text" placeholder="Last name" name=lname value="" style="margin-left:1px;margin-right: 1px; width:175px; margin-bottom: 3px;"><br/>
			<input type="email" placeholder="Email" name=email value="" style="width: 357px; margin-bottom: 3px"><br/>
			<input type="password" placeholder="Password" name=passwd value="" style="width: 275px">
			<input type="submit" value="register" style="width:78px; border:0px;background-color:#4A849F; padding:3px;">
			<input type="hidden" name=from value="register">
        </form>
</div>
