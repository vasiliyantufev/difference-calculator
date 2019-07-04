<?php

namespace Differ\tests;

use function DifferenceCalculator\diff;
use \PHPUnit\Framework\TestCase;


class DifferTest extends TestCase
{

const PATH_FILES = 'files' . DIRECTORY_SEPARATOR;

const PRETTY = <<<DOC
{
    common: {
        setting1: Value 1
      - setting2: 200
        setting3: true
      - setting6: {
            key: value
        }
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
    }
    group1: {
      + baz: bars
      - baz: bas
        foo: bar
    }
  - group2: {
        abc: 12345
    }
  + group3: {
        fee: 100500
    }
}
DOC;

const PLAIN = <<<DOC
Property 'common.setting2' was removed
Property 'common.setting6' was removed
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: 'complex value'
Property 'group1.baz' was changed. From 'bas' to 'bars'
Property 'group2' was removed
Property 'group3' was added with value: 'complex value'
DOC;

    private function  getPath(string $file)
    {
        return self::PATH_FILES.$file;
    }

//    public function testPretty()
//    {
//        $this->assertEquals(self::PRETTY, diff('pretty', $this->getPath('testBefore.json'),$this->getPath('testAfter.json')));
//    }

//    public function testPlain()
//    {
//        $this->assertEquals(self::PLAIN, diff('plain', $this->getPath('testBefore.json'),$this->getPath('testAfter.json')));
//    }

    public function testNotLol()
    {
        $this->assertNotEquals('lol','lol2');
    }
    public function testLol()
    {
        $this->assertEquals('lol','lol');
    }
}