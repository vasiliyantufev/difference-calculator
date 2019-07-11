<?php

namespace Differ\tests;

use function DifferenceCalculator\genDiff;
use \PHPUnit\Framework\TestCase;

class DifferTest extends TestCase
{
    const PATH_FILES = 'tests' . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;

    private function getFilePath(string $file = '')
    {
        return self::PATH_FILES . $file;
    }

    public function testPretty()
    {
        $diff = genDiff($this->getFilePath('testBefore.json'), $this->getFilePath('testAfter.json'));
        $this->assertStringEqualsFile($this->getFilePath('pretty'), $diff);
//        $this->assertEquals(
//            Structure\PRETTY,
//            genDiff($this->getFilePath('testBefore.json'), $this->getFilePath('testAfter.json'), 'pretty')
//        );
    }

    public function testPlain()
    {
        $diff = genDiff($this->getFilePath('testBefore.json'), $this->getFilePath('testAfter.json'), 'plain');
        $this->assertStringEqualsFile($this->getFilePath('plain'), $diff);
//        $this->assertEquals(
//            Structure\PLAIN,
//            genDiff($this->getFilePath('testBefore.json'), $this->getFilePath('testAfter.json'), 'plain')
//        );
    }

    public function testJson()
    {
        $diff = genDiff($this->getFilePath('testBefore.json'), $this->getFilePath('testAfter.json'), 'json');
        $this->assertStringEqualsFile($this->getFilePath('ast_json'), $diff);
//        $this->assertEquals(
//            Structure\JSON,
//            genDiff($this->getFilePath('testBefore.json'), $this->getFilePath('testAfter.json'), 'json')
//        );
    }

    public function testYaml()
    {
        $diff = genDiff($this->getFilePath('before.yaml'), $this->getFilePath('after.yaml'), 'json');
        $this->assertStringEqualsFile($this->getFilePath('ast_yaml'), $diff);
//        $this->assertEquals(
//            Structure\YAML_JSON,
//            genDiff($this->getFilePath('before.yaml'), $this->getFilePath('after.yaml'), 'json')
//        );
    }

    public function testFormat()
    {
        $this->assertNotEmpty(genDiff($this->getFilePath('before.json'), $this->getFilePath('after.json'), 'json'));
    }

    public function testFormatException()
    {
        try {
            $this->assertNotEmpty(genDiff($this->getFilePath('before.lol'), $this->getFilePath('after.lol'), 'json'));
        } catch (\Exception $e) {
            $this->assertEquals('Cannot find diff generator for specified format', $e->getMessage());
        }
    }
}
