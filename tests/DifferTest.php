<?php

namespace Differ\tests;

use function DifferenceCalculator\generateDifference;
use InvalidArgumentException;
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
        $diff = generateDifference($this->getFilePath('before.json'), $this->getFilePath('after.json'));
        $this->assertStringEqualsFile($this->getFilePath('pretty_json'), $diff);
    }

    public function testPlainJson()
    {
        $diff = generateDifference($this->getFilePath('before.json'), $this->getFilePath('after.json'), 'plain');
        $this->assertStringEqualsFile($this->getFilePath('plain_json'), $diff);
    }

    public function testPrettyYaml()
    {
        $diff = generateDifference($this->getFilePath('before.yaml'), $this->getFilePath('after.yaml'));
        $this->assertStringEqualsFile($this->getFilePath('pretty_yaml'), $diff);
    }

    public function testPlainYaml()
    {
        $diff = generateDifference($this->getFilePath('before.yaml'), $this->getFilePath('after.yaml'), 'plain');
        $this->assertStringEqualsFile($this->getFilePath('plain_yaml'), $diff);
    }

    public function testFileFormatException()
    {
        try {
            generateDifference($this->getFilePath('before.lol'), $this->getFilePath('after.lol'));
            $this->fail('expected file format');
        } catch (\Exception $e) {
            $this->assertEquals('invalid file format', $e->getMessage());
        }
    }

    public function testUtilityFormatException()
    {
        try {
            generateDifference($this->getFilePath('before.json'), $this->getFilePath('after.json'), 'lol');
            $this->fail('expected utility format');
        } catch (\Exception $e) {
            $this->assertEquals('wrong utility format', $e->getMessage());
        }
    }
}
