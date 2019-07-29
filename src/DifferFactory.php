<?php

namespace DifferenceCalculator\DifferFactory;

use function DifferenceCalculator\Formatters\json\jsonFormatting;
use function DifferenceCalculator\Formatters\plain\plainFormatting;
use function DifferenceCalculator\Formatters\pretty\prettyFormatting;

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
