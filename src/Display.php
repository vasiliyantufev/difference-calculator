<?php

namespace DifferenceCalculator\Display;

function json(array $tree)
{
    //var_dump(json_encode($tree, JSON_PRETTY_PRINT));
    return json_encode($tree, JSON_PRETTY_PRINT);
}

function pretty(array $tree, int $level = 0)
{
    $offset = str_pad('', $level * 4, " ");

    $prettyDisplay = array_reduce($tree, function ($acc, $key) use ($offset, $level) {
        switch ($key['type']) {
            case 'changed':
                $acc[] = "{$offset} -{$key['node']}: {$key['before']}";
                $acc[] = "{$offset} +{$key['node']}: {$key['after']}";
                break;
            case 'added':
                $acc[] = "{$offset} +{$key['node']}: {$key['after']}";
                break;
            case 'removed':
                $acc[] = "{$offset} -{$key['node']}: {$key['before']}";
                break;
            case 'nested':
                $acc[] = pretty($key['children'], $level + 1);
                break;
        }
        return $acc;
    });

//    var_dump(implode(PHP_EOL, $prettyDisplay));
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

    //var_dump(implode(PHP_EOL, $plainDisplay));
    return implode(PHP_EOL, $plainDisplay);
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
