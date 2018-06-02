<?php
session_start();
include_once('partial/header.php');
?>
<div>
        <h1>LOGIN</h1>
		<?php
			if (!empty($_GET['err']))
			{
				echo "<h3>login Error: ".$_GET['err']."</h3>";
			}
		?>
        <form action="controller/people.php" method="POST">
                <input type="email" placeholder="email" name=email value="">
                <input type="password" placeholder="passwd" name=passwd value="">
                <input type="submit" value="login">
                <input type="hidden" name=from value="login">
        </form>
		<a href="register.php">Not register yet? regiseter herer!</a>
</div>
