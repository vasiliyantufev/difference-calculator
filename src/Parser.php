<?php

namespace DifferenceCalculator\Parser;
use Symfony\Component\Yaml\Yaml;

function parseFile($format, $pathToFile)
{
    $content = file_get_contents($pathToFile);
    if ($format == 'json') {
        $array = jsonParsed($content);
    }
    if ($format == 'yaml') {
        $array = yamlParsed($content);
    }
    return $array;
}

function jsonParsed($content)
{
    $parserContent = json_decode($content, true);
    return $parserContent;
}

function yamlParsed($content)
{
    $parserContent = Yaml::parse($content);
    return $parserContent;
}
