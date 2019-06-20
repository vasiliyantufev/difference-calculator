<?php

namespace DifferenceCalculator;

use Funct;
use Symfony\Component\Yaml\Yaml;

const FORMATS = ['json', 'yaml'];

function diff($fmt, $pathToFile1, $pathToFile2)
{
    if(is_null($format = defineFormat($pathToFile1, $pathToFile2))) {
        echo 'invalid file format'.PHP_EOL;
        exit();
    }
    $parseFile1 = parserFile($format, $pathToFile1);
    $parseFile2 = parserFile($format, $pathToFile2);

    //var_dump($parseFile1);
    //var_dump($parseFile2);

    ASTBuilder($parseFile1, $parseFile2);
}

function defineFormat($pathToFile1, $pathToFile2)
{
    $file1_info = pathinfo($pathToFile1);
    $file2_info = pathinfo($pathToFile2);
    if(!isset($file1_info['extension']) || !isset($file2_info['extension'])) {
        return Null;
    }
    if(!in_array($file1_info['extension'], FORMATS) && !in_array($file2_info['extension'], FORMATS)) {
        return Null;
    }
    if($file1_info['extension'] != $file2_info['extension']) {
        return Null;
    }
    return $file1_info['extension'];
}

function parserFile($format, $pathToFile)
{
    if($format == 'json'){
        $array = jsonParser($pathToFile);
    }
    if ($format == 'yaml'){
        $array = yamlParser($pathToFile);
    }
    return $array;
}

function jsonParser($pathToFile)
{
    //bin/gendiff /home/walle/projects/hexlet/projects/difference-calculator/files/before.json /home/walle/projects/hexlet/projects/difference-calculator/files/after.json
    $fileParser = json_decode(file_get_contents($pathToFile), true);
    return $fileParser;
}

function yamlParser($pathToFile)
{
    //bin/gendiff /home/walle/projects/hexlet/projects/difference-calculator/files/before.yaml /home/walle/projects/hexlet/projects/difference-calculator/files/after.yaml
    $fileParser = Yaml::parse(file_get_contents($pathToFile));
    return $fileParser;
}


function ASTBuilder(array $before, array $after)
{
    $allPropertiesNames = array_unique(array_merge(array_keys($before), array_keys($after)));

    $ASTtree = array_reduce($allPropertiesNames, function ($acc, $key) use ($before, $after) {

        $beforeValue = $before[$key] ?? null;
        $afterValue  = $after[$key] ?? null;

        $added  = !array_key_exists($key, $before);
        if($added) {
            $acc[] = ['type' => 'added', 'node' => $key, 'before' => '', 'after' => $afterValue];
            return $acc;
        }

        $delete = !array_key_exists($key, $after);
        if($delete) {
            $acc[] = ['type' => 'removed', 'node' => $key, 'before' => $beforeValue, 'after' => ''];
            return $acc;
        }

        if(is_array($beforeValue) && is_array($afterValue)) {
            $children = ASTBuilder($beforeValue, $afterValue);
            $acc[] = ['type' => 'nested', 'name' => $key, 'children' => $children];
        }

        if($beforeValue !== $afterValue) {
            $acc[] = ['type' => 'changed', 'node' => $key, 'before' => $beforeValue, 'after' => $afterValue];
            return $acc;
        }

        $acc[] = ['type' => 'unchanged', 'node' => $key, 'before' => $beforeValue, 'after' => $afterValue];
        return $acc;
    }, []);

    //var_dump($ASTtree);
    return $ASTtree;
}
