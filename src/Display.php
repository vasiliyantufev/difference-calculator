<?php

namespace DifferenceCalculator\Display;

use function DifferenceCalculator\Prepare\prepareForDiff;
use function DifferenceCalculator\Prepare\prepareValue;

function json(array $tree)
{
    return json_encode($tree, JSON_PRETTY_PRINT);
}

function pretty(array $tree, int $level = 0)
{
    $offset = str_pad('', $level * 4, ' ');

    $prettyDisplay = array_reduce($tree, function ($acc, $key) use ($offset, $level) {
        switch ($key['type']) {
            case 'added':
                $after = prepareForDiff($key['after'], $level + 1);
                $acc[] = "{$offset}  + {$key['node']}: {$after}";
                break;
            case 'removed':
                $before = prepareForDiff($key['before'], $level + 1);
                $acc[] = "{$offset}  - {$key['node']}: {$before}";
                break;
            case 'unchanged':
                $before = prepareForDiff($key['before'], $level + 1);
                $acc[] = "{$offset}    {$key['node']}: {$before}";
                break;
            case 'nested':
                $children = pretty($key['children'], $level + 1);
                $acc[] = "{$offset}    {$key['name']}: {$children}";
                break;
            case 'changed':
                $after = prepareForDiff($key['after'], $level + 1);
                $acc[] = "{$offset}  + {$key['node']}: {$after}";
                $before = prepareForDiff($key['before'], $level + 1);
                $acc[] = "{$offset}  - {$key['node']}: {$before}";
                break;
        }
        return $acc;
    }, ['{']);
    $prettyDisplay[] = "{$offset}}";

    return implode(PHP_EOL, $prettyDisplay);
}

function plain(array $tree, $path = '')
{
    $plainDisplay = array_reduce($tree, function ($acc, $key) use ($path) {
        if ($key['type'] != 'nested') {
            $before = is_array($key['before']) ? 'complex value' : prepareValue($key['before']);
            $after  = is_array($key['after'])  ? 'complex value' : prepareValue($key['after']);
        }
        switch ($key['type']) {
            case 'nested':
                $acc[] = plain($key['children'], "{$path}{$key['name']}.");
                break;
            case 'added':
                $acc[] = "Property '{$path}{$key['node']}' was added with value: '{$after}'";
                break;
            case 'removed':
                $acc[] = "Property '{$path}{$key['node']}' was removed";
                break;
            case 'changed':
                if ($before != 'complex value' || $after != 'complex value') {
                    $acc[] = "Property '{$path}{$key['node']}' was changed. From '{$before}' to '{$after}'";
                }
                break;
        }
        return $acc;
    });

    return implode(PHP_EOL, $plainDisplay);
}
