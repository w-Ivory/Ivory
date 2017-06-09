<?php
function Swap(&$l, &$r)
{
	$l = $l + $r;
	$r = $l - $r;
	$l = $l - $r;
}

function Fibo($n)
{
	if($n < 2)
	{
		return $n;
	}

	$current = 1;	//Element actuel, commence a Fibo(1)=1
	$previous = 0;	//Element precedent, commence a Fibo(0)=0
	$n--;	//On en est deja a l'element 1, compter une iteration
	do
	{
		//$previous = $previous + $current;
		$previous += $current;
		Swap($previous, $current);
		$n--;
	}
	while($n > 0);

	return $current;
}

echo Fibo(1000000);