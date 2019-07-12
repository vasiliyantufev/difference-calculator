<?php

namespace Differ\tests;

use function DifferenceCalculator\genDiff;
use \PHPUnit\Framework\TestCase;

class DifferTest extends TestCase
{
    const PATH_FILES = 'tests' . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;

    private function getFilePath(string $filename = '')
    {
        return self::PATH_FILES . $filename;
    }

    public function testPrettyJson()
    {
        $diff = genDiff($this->getFilePath('before.json'), $this->getFilePath('after.json'));
        $this->assertStringEqualsFile($this->getFilePath('pretty_json'), $diff);
    }

    public function testPlainJson()
    {
        $diff = genDiff($this->getFilePath('before.json'), $this->getFilePath('after.json'), 'plain');
        $this->assertStringEqualsFile($this->getFilePath('plain_json'), $diff);
    }

    public function testPrettyYaml()
    {
        $diff = genDiff($this->getFilePath('before.yaml'), $this->getFilePath('after.yaml'));
        $this->assertStringEqualsFile($this->getFilePath('pretty_yaml'), $diff);
    }

    public function testPlainYaml()
    {
        $diff = genDiff($this->getFilePath('before.yaml'), $this->getFilePath('after.yaml'), 'plain');
        $this->assertStringEqualsFile($this->getFilePath('plain_yaml'), $diff);

    }

    public function testFormatException()
    {
        try {
            genDiff($this->getFilePath('before.lol'), $this->getFilePath('after.lol'), 'json');
        } catch (\Exception $e) {
            $this->assertEquals('Cannot find diff generator for specified format', $e->getMessage());
        }
    }
}
