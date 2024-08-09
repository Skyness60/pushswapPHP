 <?php

function ft_swap(array &$array)
{
    $tmp = $array[0];
    $array[0] = $array[1];
    $array[1] = $tmp;
}

function ft_pick(array &$from, array &$to)
{
    if (!empty($from)) {
        $movedElement = array_shift($from);
        array_unshift($to, $movedElement);
    }
}

function ft_rotate_left(array &$array)
{
    $firstElement = array_shift($array);
    array_push($array, $firstElement);
}

function ft_rotate_right(array &$array)
{
    $lastElement = array_pop($array);
    array_unshift($array, $lastElement);
}

function ft_sort(array &$array)
{
	$len = count($array);
	$i = 0;
	$j = 0;
	while ($i < $len)
	{
		while ($j < $len - 1 - $i)
		{
			if ($array[$j] > $array[$j + 1])
			{
				$tmp = $array[$j];
				$array[$j] = $array[$j + 1];
				$array[$j + 1] = $tmp;
			}
			$j++;
		}
		$i++;
	}
}


function ft_is_sorted(array $array)
{
    $sortedArray = $array;
    ft_sort($sortedArray);
    return $array == $sortedArray;
}

function ft_get_median($length)
{
    if ($length % 2 != 0) {
        return ceil($length / 2);
    } else {
        return $length / 2 - 1;
    }
}

array_shift($argv);

$inputArray = $argv;
$auxiliaryArray = [];
$actions = [];

while (!empty($inputArray) && !ft_is_sorted($inputArray) || !empty($auxiliaryArray)) {
    if (empty($inputArray) || ft_is_sorted($inputArray)) {
        while (!empty($auxiliaryArray)) {
            ft_pick($auxiliaryArray, $inputArray);
            $actions[] = "pa";
        }
        break;
    }

    $minValue = min($inputArray);
    $maxValue = max($inputArray);

    $count = count($inputArray);

    if ($minValue == $inputArray[0]) {
        ft_pick($inputArray, $auxiliaryArray);
        $actions[] = "pb";
    } elseif ($minValue == $inputArray[$count - 1]) {
        ft_rotate_right($inputArray);
        $actions[] = "rra";
    } elseif ($maxValue == $inputArray[0]) {
        ft_rotate_left($inputArray);
        $actions[] = "ra";
    } else {
        if ($minValue == $inputArray[1]) {
            ft_swap($inputArray);
            $actions[] = "sa";
        } elseif (array_search($minValue, $inputArray) > ft_get_median($count)) {
            $keyMin = array_search($minValue, $inputArray);
            while ($keyMin != $count - 1) {
                ft_rotate_right($inputArray);
                $actions[] = "rra";
                $keyMin = array_search($minValue, $inputArray);
            }
        } else {
            $keyMin = array_search($minValue, $inputArray);
            while ($keyMin > 1) {
                ft_rotate_left($inputArray);
                $actions[] = "ra";
                $keyMin = array_search($minValue, $inputArray);
            }
        }
    }
}

echo implode("\n", $actions) . "\n";
