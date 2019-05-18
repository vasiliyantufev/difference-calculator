<?php

namespace DifferenceCalculator;

use Funct;
use Symfony\Component\Yaml\Yaml;

const FORMATS = ['json', 'yaml'];

function diff($fmt, $pathToFile1, $pathToFile2)
{

    $format = defineFormat($pathToFile1, $pathToFile2);

    if(!$format){
        echo 'err';
    }
    if($format == 'json'){
        $arrays = jsonParser($pathToFile1, $pathToFile2);
    }
    if ($format == 'yaml'){
        $arrays = yamlParser($pathToFile1, $pathToFile2);
    }

    var_dump(findingDifferences($arrays));

    //var_dump($arrays);
}

function defineFormat($pathToFile1, $pathToFile2)
{

    $file1_info = pathinfo($pathToFile1);
    $file2_info = pathinfo($pathToFile2);

    if($file1_info['extension'] != $file2_info['extension']){
        return false;
    }

    if(!in_array($file1_info['extension'], FORMATS)){
        return false;
    }

    return $file1_info['extension'];
}

function jsonParser($pathToFile1, $pathToFile2)
{
    //bin/gendiff /home/walle/projects/hexlet/projects/difference-calculator/files/before.json /home/walle/projects/hexlet/projects/difference-calculator/files/after.json
    $fileParser1 = (array)json_decode(file_get_contents($pathToFile1, "rb"));
    $fileParser2 = (array)json_decode(file_get_contents($pathToFile2, "rb"));
    return [$fileParser1 , $fileParser2];
}

function yamlParser($pathToFile1, $pathToFile2)
{
    //bin/gendiff /home/walle/projects/hexlet/projects/difference-calculator/files/before.yaml /home/walle/projects/hexlet/projects/difference-calculator/files/after.yaml
    $fileParser1 = Yaml::parse(file_get_contents($pathToFile1, "rb"), true);
    $fileParser2 = Yaml::parse(file_get_contents($pathToFile2, "rb"), true);
    return [$fileParser1 , $fileParser2];
}

function findingDifferences($arrays)
{
    //  формируем массив
    $newFile = [];

    //  пройтись по первому массиву
    foreach ($arrays[0] as $key => $value) {
        //  если ключа не существует во втором массиве, то добавить из первого массива
        if(!array_key_exists($key, $arrays[1])) {
            $newFile += ['-'.$key => $value];
        }
        //  если ключ существует
        if (array_key_exists($key, $arrays[1])) {
            //  и в первом и во втором массиве и значения одинаковые, то добавить из первого массива
            if ($value === $arrays[1][$key]) {
                $newFile += [$key => $value];
            }
            //  и в первом и во втором массиве и значения разные, то добавить из первого массива и из второго
            elseif ($value !== $arrays[1][$key]) {
                $newFile += ['+'.$key => [$value]];
                $newFile += ['-'.$key => [$arrays[1][$key]]];
            };
        }
    }

    //  добавить недостающие элементы из второго
    $newFile2 = array_diff_key($arrays[1], $arrays[0]);

    $myarray = array_map(function($key, $value) {
        return "+{$key} => {$value}";
    }, array_keys($newFile2), $newFile2);

    $newFile += $myarray;
    return json_encode($newFile);
}
