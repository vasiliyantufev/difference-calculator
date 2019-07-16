<?php

namespace DifferenceCalculator\Formatters\json;

function json(array $tree)
{
    return json_encode($tree, JSON_PRETTY_PRINT);
}