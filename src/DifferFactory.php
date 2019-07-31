<?php

namespace DifferenceCalculator\DifferFactory;

use function DifferenceCalculator\Formatters\JsonFormatter\jsonFormatting;
use function DifferenceCalculator\Formatters\PlainFormatter\plainFormatting;
use function DifferenceCalculator\Formatters\PrettyFormatter\prettyFormatting;

function getDiffBuilder($fmt, $tree)
{
    switch ($fmt) {
        case 'pretty':
            return prettyFormatting($tree);
        case 'plain':
            return plainFormatting($tree);
        case 'json':
            return jsonFormatting($tree);
    }
}
