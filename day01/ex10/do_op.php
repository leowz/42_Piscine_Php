#!/usr/bin/php
<?php
function is_opcode($opcode)
{
	if ($opcode === "+" || $opcode === "-" || $opcode === "*" || $opcode === "/"
		|| $opcode === "%")
		return true;
	return false;
}

if ($argc != 4)
{
	printf("Incorrect Parameters\n");
}
else
{
	$op1 = trim($argv[1]);
	$op2 = trim($argv[3]);
	$opcode = trim($argv[2]);
	if (!is_numeric($op1) || !is_numeric($op2) || !is_opcode($opcode))
		printf("Incorrect Parameters\n");
	else
	{
		$n1 = intval($op1);
		$n2 = intval($op2);
		if ($opcode == "+")
			$ret = $n1 + $n2;
		else if ($opcode == "-")
			$ret = $n1 - $n2;
		else if ($opcode == "*")
			$ret = $n1 * $n2;
		else if ($opcode == "/")
			$ret = $n1 / $n2;
		else if ($opcode == "%")
			$ret = $n1 % $n2;
		printf("%d\n", $ret);
	}
}
?>
