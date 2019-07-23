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

    $parsedFile1 = parseFile($formatFile1, $pathToFile1);
    $parsedFile2 = parseFile($formatFile2, $pathToFile2);

    $ASTTree = builder($parsedFile1, $parsedFile2);
    $differ  = getDiffBuilder($fmt, $ASTTree);

    //print_r($differ . PHP_EOL);
    return $differ;
}
