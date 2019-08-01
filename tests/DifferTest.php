<?php

namespace Differ\tests;

use function DifferenceCalculator\generateDifference;
use \PHPUnit\Framework\TestCase;
use RuntimeException;

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
        $this->expectException(RuntimeException::class);
        generateDifference($this->getFilePath('before.lol'), $this->getFilePath('after.lol'));
    }

    public function testUtilityFormatException()
    {
        $this->expectException(RuntimeException::class);
        generateDifference($this->getFilePath('before.json'), $this->getFilePath('after.json'), 'lol');
    }
}
