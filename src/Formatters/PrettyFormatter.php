<?php

namespace DifferenceCalculator\Formatters\pretty;

use function DifferenceCalculator\Helper\stringifyValue;

function pretty(array $tree, int $level = 0)
{
    $offset = str_pad('', $level * 4, ' ');

    $prettyDisplay = array_reduce($tree, function ($acc, $key) use ($offset, $level) {
        switch ($key['type']) {
            case 'added':
                $after = stringify($key['afterValue'], $level + 1);
                $acc[] = "{$offset}  + {$key['node']}: {$after}";
                break;
            case 'removed':
                $before = stringify($key['beforeValue'], $level + 1);
                $acc[] = "{$offset}  - {$key['node']}: {$before}";
                break;
            case 'unchanged':
                $before = stringify($key['beforeValue'], $level + 1);
                $acc[] = "{$offset}    {$key['node']}: {$before}";
                break;
            case 'nested':
                $children = pretty($key['children'], $level + 1);
                $acc[] = "{$offset}    {$key['name']}: {$children}";
                break;
            case 'changed':
                $after = stringify($key['afterValue'], $level + 1);
                $acc[] = "{$offset}  + {$key['node']}: {$after}";
                $before = stringify($key['beforeValue'], $level + 1);
                $acc[] = "{$offset}  - {$key['node']}: {$before}";
                break;
        }
        return $acc;
    }, ['{']);
    $prettyDisplay[] = "{$offset}}";

    return implode(PHP_EOL, $prettyDisplay);
}


function stringify($value, $level)
{
    return is_array($value) ? stringifyArray($value, $level) : stringifyValue($value);
}

function stringifyArray(array $items, $level)
{
    $offset = str_pad('', $level * 4, ' ');
    $properties = array_keys($items);
    $lines = array_reduce($properties, function ($lines, $prop) use ($items, $offset, $level) {
        $preparedValue = stringify($items[$prop], $level + 1);
        $lines[] = "{$offset}    {$prop}: {$preparedValue}";
        return $lines;
    }, ["{"]);
    $lines[] = "{$offset}}";
    return implode(PHP_EOL, $lines);
}
