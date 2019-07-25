<?php

namespace DifferenceCalculator\DifferFactory;

use function DifferenceCalculator\Formatters\json\json as formatJson;
use function DifferenceCalculator\Formatters\plain\plain as formatPlain;
use function DifferenceCalculator\Formatters\pretty\pretty as formatPretty;

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
