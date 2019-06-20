<?php

use const DifferenceCalculator\DISPLAY_FORMAT;

function showASTTree($fmt, $tree)
{
    if(!in_array($fmt, DISPLAY_FORMAT)) {
        return Null;
    }
    if($fmt == 'pretty'){
        \DifferenceCalculator\pretty($tree);
    }
    if($fmt == 'plain') {
        \DifferenceCalculator\plain($tree);
    }

}

function pretty($tree)
{
    var_dump($tree);
}

function plain($tree)
{
    $plainDisplay = array_reduce($tree, function ($acc, $key) {
        var_dump($key);
        //return
    });

    //var_dump($plainDisplay);

    return $plainDisplay;
}