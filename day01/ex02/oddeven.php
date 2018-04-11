#!/usr/bin/php
<?php
	while (1)
	{
		printf("Enter a number: ");
		$str = fgets(STDIN);
		if ($str == false)
		{
			echo "\n";
			break ;
		}
		$str = str_replace("\n", "", "$str");
		if ($str === "" || !is_numeric($str))
		{
			printf("'%s' is not a number\n", $str);
			continue ;
		}
		$i = $str;
		if ($i % 2)
			printf("The number %ld is odd\n", $i);
		else
			printf("The number %ld is even\n", $i);
	}
?>
