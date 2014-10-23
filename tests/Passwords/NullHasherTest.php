<?php

namespace Base\User\Passwords;

class NullHasherTest extends \PHPUnit_Framework_TestCase
{
    public function testHashAndVerify()
    {
        $hasher = new NullHasher();
        $hash = $hasher->hash('test12345');
        $this->assertTrue($hasher->verify('test12345', $hash));
        $this->assertFalse($hasher->verify('test12346', $hash));
    }

    public function testUpgrade()
    {
        $hasher = new NullHasher();
        $hash = $hasher->hash('test12345');
        $this->assertInternalType('string', $hasher->upgrade('test12345', $hash));
    }
}

