<?php

namespace Differ\tests;

require_once('fixtures/structure.php');

use function DifferenceCalculator\diff;
use \PHPUnit\Framework\TestCase;


class DifferTest extends TestCase
{

    private function getPath(string $file)
    {
        return PATH_FILES . $file;
    }

    public function testPlain()
    {
        $this->assertEquals(PLAIN, diff('plain', $this->getPath('testBefore.json'), $this->getPath('testAfter.json')));
    }

//    public function testPretty()
//    {
//        $this->assertEquals(self::PRETTY, diff('pretty', $this->getPath('testBefore.json'),
//              $this->getPath('testAfter.json')));\
//    }
}
