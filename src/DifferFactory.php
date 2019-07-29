<?php

namespace DifferenceCalculator\DifferFactory;

use function DifferenceCalculator\Formatters\json\jsonFormatting as formatJson;
use function DifferenceCalculator\Formatters\plain\plainFormatting as formatPlain;
use function DifferenceCalculator\Formatters\pretty\prettyFormatting as formatPretty;

function getDiffBuilder($fmt, $tree)
{
    switch ($fmt) {
        case 'pretty':
            return formatPretty($tree);
        case 'plain':
            return formatPlain($tree);
        case 'json':
            return formatJson($tree);
    }
}
