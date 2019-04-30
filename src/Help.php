<?php

namespace DifferenceCalculator;

use Docopt;

function help()
{

    $doc = <<<DOC
Generate diff.
Usage:
  gendiff (-h|--help)
  gendiff [--format <fmt>] <firstFile> <secondFile>
Options:
  -h --help                     Show this screen
  --format <fmt>                Report format [default: pretty]
DOC;
    $args = Docopt::handle($doc);
    $diff = Differ\differ\genDiff($args['--format'], $args['<firstFile>'], $args['<secondFile>']);
    print_r($diff);
    echo PHP_EOL;

}