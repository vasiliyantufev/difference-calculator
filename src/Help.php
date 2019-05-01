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
    echo PHP_EOL;
}