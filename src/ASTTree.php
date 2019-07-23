<?php

namespace DifferenceCalculator\Tree;

use function DifferenceCalculator\Formatters\json\json;
use function DifferenceCalculator\Formatters\plain\plain;
use function DifferenceCalculator\Formatters\pretty\pretty;

function getDiffBuilder($fmt, $tree)
{
    switch ($fmt) {
        case 'pretty':
            return pretty($tree);
        case 'plain':
            return plain($tree);
        case 'json':
            return json($tree);
    }
}

function builder(array $before, array $after)
{
    $allPropertiesNames = array_unique(array_merge(array_keys($before), array_keys($after)));

    $ASTtree = array_reduce($allPropertiesNames, function ($acc, $key) use ($before, $after) {

        $beforeValue = $before[$key] ?? null;
        $afterValue  = $after[$key] ?? null;

        $added  = !array_key_exists($key, $before);
        if ($added) {
            $acc[] = ['type' => 'added', 'node' => $key, 'beforeValue' => '', 'afterValue' => $afterValue];
            return $acc;
        }

        $delete = !array_key_exists($key, $after);
        if ($delete) {
            $acc[] = ['type' => 'removed', 'node' => $key, 'beforeValue' => $beforeValue, 'afterValue' => ''];
            return $acc;
        }

        if (is_array($beforeValue) && is_array($afterValue)) {
            $children = builder($beforeValue, $afterValue);
            $acc[] = ['type' => 'nested', 'name' => $key, 'children' => $children];
        }

        if ($beforeValue !== $afterValue) {
            $acc[] = ['type' => 'changed', 'node' => $key, 'beforeValue' => $beforeValue, 'afterValue' => $afterValue];
            return $acc;
        }

        $acc[] = ['type' => 'unchanged', 'node' => $key, 'beforeValue' => $beforeValue, 'afterValue' => $afterValue];
        return $acc;
    }, []);

    return $ASTtree;
}
