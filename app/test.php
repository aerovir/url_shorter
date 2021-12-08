<?php

function printNumbers($firstNumber)
{
    while ($firstNumber !== 0) {
        print_r($firstNumber);
        print_r('<br>');
        $firstNumber--;
    }
    echo 'finished!';
}
printNumbers(4);
