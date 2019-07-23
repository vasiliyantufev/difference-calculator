<?php

namespace DifferenceCalculator\Formatters\plain;

use function DifferenceCalculator\Helper\prepareValue;

function plain(array $tree, $path = '')
{
    $plainDisplay = array_reduce($tree, function ($acc, $key) use ($path) {

        if (isset($key['before'])) {
            $before =  is_array($key['before']) ? 'complex value' : prepareValue($key['before']);
        };
        if (isset($key['after'])) {
            $after = is_array($key['after']) ? 'complex value' : prepareValue($key['after']);
        };

        switch ($key['type']) {
            case 'added':
                $acc[] = "Property '{$path}{$key['node']}' was added with value: '{$after}'";
                break;
            case 'removed':
                $acc[] = "Property '{$path}{$key['node']}' was removed";
                break;
            case 'changed':
                $acc[] = "Property '{$path}{$key['node']}' was changed. From '{$before}' to '{$after}'";
                break;
            case 'nested':
                $acc[] = plain($key['children'], "{$path}{$key['name']}.");
                break;
        }
        return $acc;
    });

    return implode(PHP_EOL, $plainDisplay);
}
