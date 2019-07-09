<?php

namespace Differ\tests;

use function DifferenceCalculator\genDiff;
use DifferenceCalculator\Structure;
use \PHPUnit\Framework\TestCase;

class DifferTest extends TestCase
{
    private function pathFile(string $file = '')
    {
        return Structure\PATH_FILES . $file;
    }

    public function testPlain()
    {
        $this->assertEquals(
            Structure\PLAIN,
            genDiff($this->pathFile('testBefore.json'), $this->pathFile('testAfter.json'), 'plain')
        );
    }

    public function testPretty()
    {
        $this->assertEquals(
            Structure\PRETTY,
            genDiff($this->pathFile('testBefore.json'), $this->pathFile('testAfter.json'), 'pretty')
        );
    }

    public function testJson()
    {
        $this->assertEquals(
            Structure\JSON,
            genDiff($this->pathFile('testBefore.json'), $this->pathFile('testAfter.json'), 'json')
        );
    }

    public function testYaml()
    {
        $this->assertEquals(
            Structure\YAML_JSON,
            genDiff($this->pathFile('before.yaml'), $this->pathFile('after.yaml'), 'json')
        );
    }

    public function testFormat()
    {
        $this->assertNotEmpty(genDiff($this->pathFile('before.json'), $this->pathFile('after.json'), 'json'));
    }

    public function testFormatException()
    {
        try {
            $this->assertNotEmpty(genDiff($this->pathFile('before.lol'), $this->pathFile('after.lol'), 'json'));
        } catch (\Exception $e) {
            $this->assertEquals('Cannot find diff generator for specified format', $e->getMessage());
        }
    }
}
