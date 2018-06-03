<?php
include_once('head.php');
?>
<header style="background-color:#1B3440;color:white;padding:10px">
	<div class="header_container">
		<div class="header_index">
			<a class="header_link" href="index.php">HOME</a>
			  |  
			<a class="header_link" href="browse.php">Browse Movies</a>
		</div>
		<div class="header_member">
			<?php
			if (isset($_SESSION['email']) && !empty($_SESSION['email']))
			{
			
				echo '<a class="header_link" href="basket.php">Basket</a>';
				echo "\n";
				echo " | \n";
				if ($_SESSION['admin'] && $_SESSION['admin'] == 1)
				{
					echo '<a class="header_link" href="admin.php">Admin panel</a>';
					echo "\n";
					echo " | \n";
				}
				echo '<a class="header_link" href="member.php">'.$_SESSION['email'].'</a>';
				echo "\n";
				echo "(\n";
				echo '<a class="header_link" href="logout.php">'."Logout".'</a>';
				echo "\n";
				echo ")\n";
			}
			else
			{
				echo  '<a class="header_link" href="login.php">Sign in</a>';
				echo "\n";
				echo "|\n";
				echo  '<a class="header_link" href="register.php">Register</a>';
				echo "\n";
			}	
			?>
		</div>
	</div>
</header>
<hr>
