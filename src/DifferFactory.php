<?php

namespace DifferenceCalculator\DifferFactory;

use function DifferenceCalculator\Formatters\JsonFormatter\formatting as JsonFormatting;
use function DifferenceCalculator\Formatters\PlainFormatter\formatting as PlainFormatting;
use function DifferenceCalculator\Formatters\PrettyFormatter\formatting as PrettyFormatting;

function getDiffBuilder($fmt, $tree)
{
    switch ($fmt) {
        case 'pretty':
            return PrettyFormatting($tree);
        case 'plain':
            return PlainFormatting($tree);
        case 'json':
            return JsonFormatting($tree);
    }
}
