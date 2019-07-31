<?php

namespace DifferenceCalculator\Parser;
use Symfony\Component\Yaml\Yaml;

function parse($format, $content)
{
    $mapping = [
        'yml' => function ($rawData) {
            return Yaml::parse($rawData);
        },
        'json' => function ($rawData) {
            return json_decode($rawData, true);
        }
    ];

    return $mapping[$format]($content);
}