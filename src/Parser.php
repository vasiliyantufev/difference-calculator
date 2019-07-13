<?php

namespace DifferenceCalculator\Parser;
use Symfony\Component\Yaml\Yaml;

function parseFile($format, $pathToFile)
{
    $content = file_get_contents($pathToFile);
    if ($format == 'json') {
        $array = jsonParser($content);
    }
    if ($format == 'yaml') {
        $array = yamlParser($content);
    }
    return $array;
}

function jsonParser($content)
{
    $parserContent = json_decode($content, true);
    return $parserContent;
}

function yamlParser($content)
{
    $parserContent = Yaml::parse($content);
    return $parserContent;
}
