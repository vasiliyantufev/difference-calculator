<?php

namespace DifferenceCalculator;

use function DifferenceCalculator\Parser\parse;
use function DifferenceCalculator\DifferFactory\getDiffBuilder;
use function DifferenceCalculator\AST\buildAST;
use function DifferenceCalculator\Validation\validateFileFormat;
use function DifferenceCalculator\Validation\validateUtilityFormat;

function generateDifference($pathToFile1, $pathToFile2, $fmt = 'pretty')
{
    $formatFile1 = validateFileFormat($pathToFile1);
    $formatFile2 = validateFileFormat($pathToFile2);
    validateUtilityFormat($fmt);

    $parsedFile1 = parse($formatFile1, file_get_contents($pathToFile1));
    $parsedFile2 = parse($formatFile2, file_get_contents($pathToFile2));

    $AST = buildAST($parsedFile1, $parsedFile2);
    $diff  = getDiffBuilder($fmt, $AST);

    print_r($diff . PHP_EOL);
    return $diff;
}
