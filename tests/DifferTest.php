<?php

namespace Differ\tests;

use \PHPUnit\Framework\TestCase;


class DifferTest extends TestCase
{
    public function testNotLol()
    {
        $this->assertNotEquals('lol','lol2');
    }
    public function testLol()
    {
        $this->assertEquals('lol','lol');
    }
}