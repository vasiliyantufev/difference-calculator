<?php

namespace DifferenceCalculator\Formatters\json;

function jsonFormatting(array $tree)
{
    return json_encode($tree, JSON_PRETTY_PRINT);
}
