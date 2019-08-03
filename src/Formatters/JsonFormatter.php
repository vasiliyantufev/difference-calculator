<?php

namespace DifferenceCalculator\Formatters\JsonFormatter;

function formatting(array $tree)
{
    return json_encode($tree, JSON_PRETTY_PRINT);
}
