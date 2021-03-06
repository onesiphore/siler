<?php

declare(strict_types=1);

namespace Siler\Test\Unit;

use PHPUnit\Framework\TestCase;
use Siler\Result\Failure;
use function Siler\Encoder\Json\encode;

class FailureTest extends TestCase
{
    public function testConstructor()
    {
        $failure = new Failure();
        $this->assertNotEmpty($failure->id());
        $this->assertNull($failure->unwrap());
        $this->assertSame(1, $failure->code());
    }

    public function testIsFailure()
    {
        $failure = new Failure();
        $this->assertTrue($failure->isFailure());
        $this->assertFalse($failure->isSuccess());
    }

    public function testJson()
    {
        $failure = new Failure(null, 1, 'test');
        $this->assertSame('{"error":true,"id":"test"}', encode($failure));

        $failure = new Failure('foo', 1, 'test');
        $this->assertSame('{"error":true,"id":"test","message":"foo"}', encode($failure));

        $failure = new Failure(['foo' => 'bar'], 1, 'test');
        $this->assertSame('{"error":true,"id":"test","foo":"bar"}', encode($failure));

        $failure = new Failure(true, 1, 'test');
        $this->assertSame('{"error":true,"id":"test","data":true}', encode($failure));
    }
}
