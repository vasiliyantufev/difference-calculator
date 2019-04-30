<?php

namespace DifferenceCalculator;

use Docopt;

function help()
{

    $doc = <<<DOC
Naval Fate.

Usage:
  naval_fate.php ship new <name>...
  naval_fate.php ship <name> move <x> <y> [--speed=<kn>]
  naval_fate.php ship shoot <x> <y>
  naval_fate.php mine (set|remove) <x> <y> [--moored | --drifting]
  naval_fate.php (-h | --help)
  naval_fate.php --version

Options:
  -h --help     Show this screen.
  --version     Show version.
  --speed=<kn>  Speed in knots [default: 10].
  --moored      Moored (anchored) mine.
  --drifting    Drifting mine.

DOC;


Docopt::handle($doc, array('version'=>'Naval Fate 2.0'));

}