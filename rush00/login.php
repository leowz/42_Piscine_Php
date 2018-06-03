<?php
session_start();
include_once('partial/header.php');
?>
<div class="login_box">
        <h1>Sign in</h1>
		<?php
			if (!empty($_GET['err']))
			{
				echo "<h3>login Error: ".$_GET['err']."</h3>";
			}
		?>
		<form action="controller/people.php" method="POST">
                <input type="email" placeholder="Email" name=email value="" style="width:200px; margin-bottom: 3px;"><br/>
                <input type="password" placeholder="Password" name=passwd value="" style="width:200px; margin-bottom: 3px;"><br/>
                <input type="submit" value="login" style="width:200px;background-color:#4A849F;border:0px; margin-bottom: 1px;">
                <input type="hidden" name=from value="login">
        </form>
		<a href="register.php" style="font-size:13px">Not registered yet? Register now!</a>
</div>
