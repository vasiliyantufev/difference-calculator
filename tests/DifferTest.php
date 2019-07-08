<?php

namespace Differ\tests;

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
        $this->assertEquals(
            PLAIN,
            diff('plain', $this->getPath('testBefore.json'), $this->getPath('testAfter.json'))
        );
    }

    public function testPretty()
    {
        $this->assertEquals(
            PRETTY,
            diff('pretty', $this->getPath('testBefore.json'), $this->getPath('testAfter.json'))
        );
    }

    public function testJson()
    {
        $this->assertEquals(
            JSON,
            diff('json', $this->getPath('testBefore.json'), $this->getPath('testAfter.json'))
        );
    }

    public function testYaml()
    {
        $this->assertEquals(
            YAML_JSON,
            diff('json', $this->getPath('before.yaml'), $this->getPath('after.yaml'))
        );
    }

    public function testFormatException()
    {
        try {
            diff('json', $this->getPath('before.lol'), $this->getPath('after.lol'));
        } catch (\Exception $e) {
            $this->assertEquals('Cannot find diff generator for specified format', $e->getMessage());
        }
    }
}
