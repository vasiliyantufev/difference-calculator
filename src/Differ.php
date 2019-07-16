<?php

namespace DifferenceCalculator;

use function DifferenceCalculator\Parser\parseFile;
use function DifferenceCalculator\Tree\builder;
use function DifferenceCalculator\Tree\getDiffBuilder;
use function DifferenceCalculator\Validate\validateFileFormat;
use function DifferenceCalculator\Validate\validateUtilityFormat;

function generateDifference($pathToFile1, $pathToFile2, $fmt = 'pretty')
{
    $formatFile1 = validateFileFormat($pathToFile1);
    $formatFile2 = validateFileFormat($pathToFile2);
    validateUtilityFormat($fmt);

    $parserFile1 = parseFile($formatFile1, $pathToFile1);
    $parserFile2 = parseFile($formatFile2, $pathToFile2);

    $differ = getDiffBuilder($fmt, builder($parserFile1, $parserFile2));

    //print_r($differ . PHP_EOL);
    return $differ;
}
