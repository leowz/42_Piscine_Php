<?php
include_once('head.php');
?>
<header>
	<div class="header_container">
	<div class="header_index">
		<a href="index.php">HOME</a>
		<a href="browse.php">Browse Movies</a>
	</div>
	<div class="header_member">
	<?php
	if (isset($_SESSION['email']) && !empty($_SESSION['email']))
	{

		echo '<a href="basket.php">Basket</a>';
		echo '<a href="member.php">'.$_SESSION['email'].'</a>';
		echo "\n";
		echo '<a href="logout.php">'."Logout".'</a>';
	}
	else
	{
		echo  '<a href="login.php">Login</a>';
		echo "\n";
		echo  '<a href="register.php">Register?</a>';
		echo "\n";
	}
	?>
	</div>
	</div>
	<div style="clear:both"></div>
</header>
<hr>
