<?php

namespace DifferenceCalculator\Formatters\plain;

function plainFormatting(array $tree, $path = '')
{
    $plainDisplay = array_reduce($tree, function ($acc, $key) use ($path) {

        $beforeValue = stringify(isset($key['beforeValue']) ? $key['beforeValue'] : null);
        $afterValue  = stringify(isset($key['afterValue']) ? $key['afterValue'] : null);

        switch ($key['type']) {
            case 'added':
                $acc[] = "Property '{$path}{$key['node']}' was added with value: '{$afterValue}'";
                break;
            case 'removed':
                $acc[] = "Property '{$path}{$key['node']}' was removed";
                break;
            case 'changed':
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

function stringify($data)
{
    return  is_object($data) ? 'complex value' : json_encode($data);
}
