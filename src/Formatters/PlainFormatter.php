<?php

namespace DifferenceCalculator\Formatters\PlainFormatter;

function plainFormatting(array $tree, $path = '')
{
    $plainDisplay = array_reduce($tree, function ($acc, $key) use ($path) {

        switch ($key['type']) {
            case 'added':
                $afterValue  = stringify($key['afterValue']);
                $acc[] = "Property '{$path}{$key['node']}' was added with value: '{$afterValue}'";
                break;
            case 'removed':
                $acc[] = "Property '{$path}{$key['node']}' was removed";
                break;
            case 'changed':
                $beforeValue = stringify($key['beforeValue']);
                $afterValue  = stringify($key['afterValue']);
                $acc[] = "Property '{$path}{$key['node']}' was changed. From '{$beforeValue}' to '{$afterValue}'";
                break;
            case 'nested':
                $acc[] = plainFormatting($key['children'], "{$path}{$key['name']}.");
                break;
        }
        return $acc;
    });

    return implode(PHP_EOL, $plainDisplay);
}
function stringify($date)
{
    return is_array($date) ? 'complex value' : stringifyValue($date);
}

function stringifyValue($value)
{
    $stringValue = $value;
    if (is_bool($value)) {
        $stringValue = $value ? 'true' : 'false';
    } elseif (is_null($value)) {
        $stringValue = 'null';
    }
    return $stringValue;
}