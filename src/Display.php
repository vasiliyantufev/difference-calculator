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
            case 'unchanged':
                $acc[] = "{$offset} {$key['node']}: {$key['before']}";
                break;
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

    var_dump(implode(PHP_EOL, $prettyDisplay));
    return implode(PHP_EOL, $prettyDisplay);
}

function plain(array $tree)
{
    $plainDisplay = array_reduce($tree, function ($acc, $key) {
        switch ($key['type']) {
            case 'added':
                $after = is_array($key['after']) ? 'complex value' : $key['after'];
                $acc[] = "Property '{$key['node']}' was added with value '{$after}'";
                break;
            case 'removed':
                $acc[] = "Property '{$key['node']}' was removed";
                break;
            case 'unchanged':
                $acc[] = "{$key['node']}: {$key['before']}";
                break;
            case 'changed':
                $before = is_array($key['before']) ? 'complex value' : $key['before'];
                $after = is_array($key['after']) ? 'complex value' : $key['after'];
                $acc[] = "Property '{$key['node']}' was changed. From '{$before}' to '{$after}'";
                break;
            case 'nested':
                $acc[] = plain($key['children']);
                break;
        }
        return $acc;
    });

    //var_dump(implode(PHP_EOL, $plainDisplay));
    return implode(PHP_EOL, $plainDisplay);
}
