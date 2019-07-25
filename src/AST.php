<?php

namespace DifferenceCalculator\AST;

function buildAST(array $oldProperties, array $newProperties)
{
    $allPropertiesNames = array_unique(array_merge(array_keys($oldProperties), array_keys($newProperties)));

    $ASTtree = array_reduce($allPropertiesNames, function ($acc, $key) use ($oldProperties, $newProperties) {

        $beforeValue = $oldProperties[$key] ?? null;
        $afterValue  = $newProperties[$key] ?? null;

        $added  = !array_key_exists($key, $oldProperties);
        if ($added) {
            $acc[] = ['type' => 'added', 'node' => $key, 'afterValue' => $afterValue];
            return $acc;
        }

        $delete = !array_key_exists($key, $newProperties);
        if ($delete) {
            $acc[] = ['type' => 'removed', 'node' => $key, 'beforeValue' => $beforeValue];
            return $acc;
        }

        if (is_array($beforeValue) && is_array($afterValue)) {
            $children = buildAST($beforeValue, $afterValue);
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
