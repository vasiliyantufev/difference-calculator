<?php

namespace DifferenceCalculator\Parser;
use Symfony\Component\Yaml\Yaml;

function parse($format, $content)
{
    if ($format == 'json') {
        $array = json_decode($content, true);
    }
    if ($format == 'yaml') {
        $array = Yaml::parse($content);
    }
    return $array;
}
