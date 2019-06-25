<?php

namespace DifferenceCalculator\Parser;
use Symfony\Component\Yaml\Yaml;

function parserFile($format, $pathToFile)
{
    if ($format == 'json') {
        $array = jsonParser($pathToFile);
    }
    if ($format == 'yaml') {
        $array = yamlParser($pathToFile);
    }
    return $array;
}

function jsonParser($pathToFile)
{
    $fileParser = json_decode(file_get_contents($pathToFile), true);
    return $fileParser;
}

function yamlParser($pathToFile)
{
    $fileParser = Yaml::parse(file_get_contents($pathToFile));
    return $fileParser;
}
