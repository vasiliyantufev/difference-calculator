<?php

namespace DifferenceCalculator\Formatters\plain;

use function DifferenceCalculator\Helper\prepareValue;

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