<?php

namespace DifferenceCalculator\Tree;

use function DifferenceCalculator\Display\json;
use function DifferenceCalculator\Display\plain;
use function DifferenceCalculator\Display\pretty;

const DISPLAY_FORMAT = ['json', 'plain', 'pretty'];

function show($fmt, $tree)
{
    //echo $fmt;
    switch ($fmt) {
        case 'pretty':
            return pretty($tree);
        case 'plain':
            return plain($tree);
        case 'json':
            return json($tree);
        default:
            throw new \RuntimeException('Cannot find diff generator for specified format');
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
            $acc[] = ['type' => 'added', 'node' => $key, 'before' => '', 'after' => $afterValue];
            return $acc;
        }

        $delete = !array_key_exists($key, $after);
        if ($delete) {
            $acc[] = ['type' => 'removed', 'node' => $key, 'before' => $beforeValue, 'after' => ''];
            return $acc;
        }

        if (is_array($beforeValue) && is_array($afterValue)) {
            $children = builder($beforeValue, $afterValue);
            $acc[] = ['type' => 'nested', 'name' => $key, 'children' => $children];
        }

        if ($beforeValue !== $afterValue) {
            $acc[] = ['type' => 'changed', 'node' => $key, 'before' => $beforeValue, 'after' => $afterValue];
            return $acc;
        }

        $acc[] = ['type' => 'unchanged', 'node' => $key, 'before' => $beforeValue, 'after' => $afterValue];
        return $acc;
    }, []);

    //var_dump($ASTtree);
    return $ASTtree;
}
