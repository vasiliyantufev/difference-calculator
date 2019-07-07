<?php

namespace DifferenceCalculator;

use function DifferenceCalculator\Parser\parserFile;
use function DifferenceCalculator\Tree\builder;
use function DifferenceCalculator\Tree\show;

const FILE_FORMAT    = ['json', 'yaml'];

function diff($fmt, $pathToFile1, $pathToFile2)
{
    if (is_null($format = defineFormat($pathToFile1, $pathToFile2))) {
        echo 'invalid file format' . PHP_EOL;
        exit();
    }
    $parseFile1 = parserFile($format, $pathToFile1);
    $parseFile2 = parserFile($format, $pathToFile2);

    //show($fmt, builder($parseFile1, $parseFile2));

//    var_dump(show($fmt, builder($parseFile1, $parseFile2)));
    print_r(show($fmt, builder($parseFile1, $parseFile2)));

    return show($fmt, builder($parseFile1, $parseFile2));
}

function defineFormat($pathToFile1, $pathToFile2)
{
    $file1_info = pathinfo($pathToFile1);
    $file2_info = pathinfo($pathToFile2);
    if (!isset($file1_info['extension']) || !isset($file2_info['extension'])) {
        return null;
    }
    if (!in_array($file1_info['extension'], FILE_FORMAT) && !in_array($file2_info['extension'], FILE_FORMAT)) {
        return null;
    }
    if ($file1_info['extension'] != $file2_info['extension']) {
        return null;
    }
    return $file1_info['extension'];
}
