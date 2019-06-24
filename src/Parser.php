<?php

namespace DifferenceCalculator\Parser;
use Symfony\Component\Yaml\Yaml;

function parserFile($format, $pathToFile)
{
    if($format == 'json'){
        $array = jsonParser($pathToFile);
    }
    if ($format == 'yaml'){
        $array = yamlParser($pathToFile);
    }
    return $array;
}

function jsonParser($pathToFile)
{
    //bin/gendiff /home/walle/projects/hexlet/projects/difference-calculator/files/before.json /home/walle/projects/hexlet/projects/difference-calculator/files/after.json
    $fileParser = json_decode(file_get_contents($pathToFile), true);
    return $fileParser;
}

function yamlParser($pathToFile)
{
    //bin/gendiff /home/walle/projects/hexlet/projects/difference-calculator/files/before.yaml /home/walle/projects/hexlet/projects/difference-calculator/files/after.yaml
    $fileParser = Yaml::parse(file_get_contents($pathToFile));
    return $fileParser;
}
