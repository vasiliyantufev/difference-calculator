<?php

namespace DifferenceCalculator;

use Funct;

function diff($pathToFile1, $pathToFile2)
{
    //Funct\Strings\classify('hello world');

    //загрузить два файла в массивы
    $handlerFile1 = fopen($pathToFile1, "rb");
    $handlerFile2 = fopen($pathToFile2, "rb");



    //найти различия
    //записать в строку и вернуть
}