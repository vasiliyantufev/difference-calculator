<?php

namespace DifferenceCalculator\Validate;

const UTILITY_FORMAT = ['json', 'plain', 'pretty'];
const FILE_FORMAT    = ['json', 'yaml'];


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