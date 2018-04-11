#!/usr/bin/php
<?php
function is_opcode($opcode)
{
	if ($opcode === "+" || $opcode === "-" || $opcode === "*" || $opcode === "/"
		|| $opcode === "%")
		return true;
	return false;
}
if ($argc != 2)
{
	printf("Incorrect Parameters\n");
	exit();
}
$rawstr = str_replace(" ", "", $argv[1]);
if (($rest = strstr($rawstr, "+")))
	$op1 = substr($rawstr, 0, strlen($rawstr) - strlen($rest));
else if (($rest = strstr($rawstr, "-")))
	$op1 = substr($rawstr, 0, strlen($rawstr) - strlen($rest));
else if (($rest = strstr($rawstr, "*")))
	$op1 = substr($rawstr, 0, strlen($rawstr) - strlen($rest));
else if (($rest = strstr($rawstr, "/")))
	$op1 = substr($rawstr, 0, strlen($rawstr) - strlen($rest));
else if (($rest = strstr($rawstr, "%")))
	$op1 = substr($rawstr, 0, strlen($rawstr) - strlen($rest));
else
{
	printf("Syntax Error\n");
	exit();
}
$opcode = substr(substr($rawstr, strlen((string)$op1)), 0, 1);
$op2 = substr($rawstr, strlen((string)$op1) + 1);
if (!is_numeric($op1) || !is_numeric($op2) || !is_opcode($opcode))
{
	printf("Syntax Error\n");
	exit();
}
if ($opcode == "+")
	$ret = $op1 + $op2;
else if ($opcode == "-")
	$ret = $op1 - $op2;
else if ($opcode == "*")
	$ret = $op1 * $op2;
else if ($opcode == "/")
	$ret = $op1 / $op2;
else if ($opcode == "%")
	$ret = $op1 % $op2;
else
{
	printf("Syntax Error\n");
	exit();
}
printf("%d\n", $ret);
?>
