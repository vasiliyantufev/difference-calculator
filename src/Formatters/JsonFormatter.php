<?php

namespace DifferenceCalculator\Formatters\JsonFormatter;

function jsonFormatting(array $tree)
{
    return json_encode($tree, JSON_PRETTY_PRINT);
}
