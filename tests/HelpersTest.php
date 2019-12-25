<?php

namespace Test;

use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    protected $bytes = 10240;

    /** @test */
    public function formatBytes()
    {
        $formatBytes = formatBytes($this->bytes);
        $this->assertSame('10 KB', $formatBytes);
    }
}
