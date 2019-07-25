<?php

namespace DifferenceCalculator\Formatters\plain;

use function DifferenceCalculator\Helper\stringifyValue;

function plain(array $tree, $path = '')
{
    $plainDisplay = array_reduce($tree, function ($acc, $key) use ($path) {

        if (isset($key['beforeValue'])) {
            $before =  is_array($key['beforeValue']) ? 'complex value' : stringifyValue($key['beforeValue']);
        };
        if (isset($key['afterValue'])) {
            $after = is_array($key['afterValue']) ? 'complex value' : stringifyValue($key['afterValue']);
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
