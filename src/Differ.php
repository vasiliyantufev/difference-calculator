<?php

namespace DifferenceCalculator;

use Funct;
use Symfony\Component\Yaml\Yaml;

function diff($fmt, $pathToFile1, $pathToFile2)
{

    //bin/gendiff /home/walle/projects/hexlet/projects/difference-calculator/files/before.json /home/walle/projects/hexlet/projects/difference-calculator/files/after.json
    //загрузить два файла в массивы
    $file1 = (array)json_decode(file_get_contents($pathToFile1, "rb"));
    $file2 = (array)json_decode(file_get_contents($pathToFile2, "rb"));

//--------------------------------------------------------------------------------------------------------------------//
//                                            найти различия
//--------------------------------------------------------------------------------------------------------------------//
//  формируем массив
    $newFile = [];

    //  пройтись по первому массиву
    foreach ($file1 as $key => $value) {
        //  если ключа не существует во втором массиве, то добавить из первого массива
        if(!array_key_exists($key, $file2)) {
            $newFile += ['-'.$key => $value];
        }
        //  если ключ существует
        if (array_key_exists($key, $file2)) {
            //  и в первом и во втором массиве и значения одинаковые, то добавить из первого массива
            if ($value === $file2[$key]) {
                $newFile += [$key => $value];
            }
            //  и в первом и во втором массиве и значения разные, то добавить из первого массива и из второго
            elseif ($value !== $file2[$key]) {
                $newFile += ['+'.$key => [$value]];
                $newFile += ['-'.$key => [$file2[$key]]];
            };
        }
    }

    //  добавить недостающие элементы из второго
    $newFile2 = array_diff_key($file2, $file1);

    $myarray = array_map(function($key, $value) {
        return "+{$key} => {$value}";
        }, array_keys($newFile2), $newFile2);

    $newFile += $myarray;

    var_dump(json_encode($newFile));

}

function yamlParser(string $content)
{
    return Yaml::parse($content, true);
}