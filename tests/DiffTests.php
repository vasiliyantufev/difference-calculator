<?php

namespace Diff\tests;

use \PHPUnit\Framework\TestCase;


class DiffTest extends TestCase
{

    public function testFail()
    {
        $this->assertIsNotInt('lol');
    }
}