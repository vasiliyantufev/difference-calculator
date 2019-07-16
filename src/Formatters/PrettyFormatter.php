<?php

namespace DifferenceCalculator\Formatters\pretty;

use function DifferenceCalculator\Helper\prepare;

function pretty(array $tree, int $level = 0)
{
    $offset = str_pad('', $level * 4, ' ');

    $prettyDisplay = array_reduce($tree, function ($acc, $key) use ($offset, $level) {
        switch ($key['type']) {
            case 'added':
                $after = prepare($key['after'], $level + 1);
                $acc[] = "{$offset}  + {$key['node']}: {$after}";
                break;
            case 'removed':
                $before = prepare($key['before'], $level + 1);
                $acc[] = "{$offset}  - {$key['node']}: {$before}";
                break;
            case 'unchanged':
                $before = prepare($key['before'], $level + 1);
                $acc[] = "{$offset}    {$key['node']}: {$before}";
                break;
            case 'nested':
                $children = pretty($key['children'], $level + 1);
                $acc[] = "{$offset}    {$key['name']}: {$children}";
                break;
            case 'changed':
                $after = prepare($key['after'], $level + 1);
                $acc[] = "{$offset}  + {$key['node']}: {$after}";
                $before = prepare($key['before'], $level + 1);
                $acc[] = "{$offset}  - {$key['node']}: {$before}";
                break;
        }
        return $acc;
    }, ['{']);
    $prettyDisplay[] = "{$offset}}";

    return implode(PHP_EOL, $prettyDisplay);
}
