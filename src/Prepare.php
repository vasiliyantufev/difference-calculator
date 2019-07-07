<?php

namespace DifferenceCalculator\Prepare;

function prepareForDiff($value, $level)
{
    return is_array($value) ? prepareArray($value, $level) : prepareValue($value);
}

function prepareValue($value)
{
    $stringValue = $value;
    if (is_bool($value)) {
        $stringValue = $value ? 'true' : 'false';
    } elseif (is_null($value)) {
        $stringValue = 'null';
    }
    return $stringValue;
}

function prepareArray(array $items, $level)
{
    $offset = str_pad('', $level * 4, ' ');
    $properties = array_keys($items);
    $lines = array_reduce($properties, function ($lines, $prop) use ($items, $offset, $level) {
        $preparedValue = prepareForDiff($items[$prop], $level + 1);
        $lines[] = "{$offset}    {$prop}: {$preparedValue}";
        return $lines;
    }, ["{"]);
    $lines[] = "{$offset}}";
    return implode(PHP_EOL, $lines);
}
