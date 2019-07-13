<?php

namespace DifferenceCalculator;

use function DifferenceCalculator\Parser\parseFile;
use function DifferenceCalculator\Tree\builder;
use function DifferenceCalculator\Tree\getDiffBuilder;

const UTILITY_FORMAT = ['json', 'plain', 'pretty'];
const FILE_FORMAT    = ['json', 'yaml'];

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

function validateFileFormat($pathToFile)
{
    $fileInfo = pathinfo($pathToFile);

    if (!isset($fileInfo['extension'])) {
        throw new \RuntimeException('invalid file format');
    }
    if (!in_array($fileInfo['extension'], FILE_FORMAT)) {
        throw new \RuntimeException('invalid file format');
    }
    return $fileInfo['extension'];
}

function validateUtilityFormat($utilityFormat)
{
    if (!in_array($utilityFormat, UTILITY_FORMAT)) {
        throw new \RuntimeException('wrong utility format');
    }
    return $utilityFormat;
}