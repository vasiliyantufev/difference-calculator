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

    $ASTtree = array_reduce($allPropertiesNames, function ($acc, $name) use ($before, $after) {

        $beforeValue = $before[$name] ?? null;
        $afterValue  = $after[$name] ?? null;

        $added  = !array_key_exists($name, $before);
        if($added) {
            $acc[] = ['type' => 'added', 'name' => $name, 'added' => $afterValue];
            return $acc;
        }

        $delete = !array_key_exists($name, $after);
        if($delete) {
            $acc[] = ['type' => 'delete', 'name' => $name, 'delete' => $beforeValue];
            return $acc;
        }

        if(is_array($beforeValue) && is_array($afterValue)) {
            //$acc[] = ['type' => 'nested', 'name' => $name];
            ASTBuilder($beforeValue, $afterValue);
        }

        if($beforeValue !== $afterValue) {
            $acc[] = ['type' => 'changed', 'name' => $name, 'after' => $afterValue, 'before' => $beforeValue];
            return $acc;
        }

        $acc[] = ['type' => 'unchanged', 'name' => $name, 'after' => $afterValue, 'before' => $beforeValue];
        return $acc;
    }, []);

    var_dump($ASTtree);
}


//function findingDifferences($file1, $file2)
//{
//    var_dump($file1);
//    var_dump($file2);
//
//    array_reduce($file1, function ($acc, $file) {
//        return $file['age'] > $acc['age'] ? $user : $acc;
//    }, $file1[0]);
//}

//function findingDifferences($arrays)
//{
//    //  формируем массив
//    $newFile = [];
//
//    //  пройтись по первому массиву
//    foreach ($arrays[0] as $key => $value) {
//        //  если ключа не существует во втором массиве, то добавить из первого массива
//        if(!array_key_exists($key, $arrays[1])) {
//            $newFile += ['-'.$key => $value];
//        }
//        //  если ключ существует
//        if (array_key_exists($key, $arrays[1])) {
//            //  и в первом и во втором массиве и значения одинаковые, то добавить из первого массива
//            if ($value === $arrays[1][$key]) {
//                $newFile += [$key => $value];
//            }
//            //  и в первом и во втором массиве и значения разные, то добавить из первого массива и из второго
//            elseif ($value !== $arrays[1][$key]) {
//                $newFile += ['+'.$key => [$value]];
//                $newFile += ['-'.$key => [$arrays[1][$key]]];
//            };
//        }
//    }
//
//    //  добавить недостающие элементы из второго
//    $newFile2 = array_diff_key($arrays[1], $arrays[0]);
//
//    $myarray = array_map(function($key, $value) {
//        return "+{$key} => {$value}";
//    }, array_keys($newFile2), $newFile2);
//
//    $newFile += $myarray;
//    return json_encode($newFile);
//}
