<?php

namespace Base\User\Passwords;

class PortableHasherTest extends \PHPUnit_Framework_TestCase
{
    public function testHashAndVerify()
    {
        $hasher = new PortableHasher(8, true);
        $hash = $hasher->hash('test12345');
        $this->assertTrue($hasher->verify('test12345', $hash));
        $this->assertFalse($hasher->verify('test12346', $hash));
    }

    public function testUpgrade()
    {
        $hasher = new PortableHasher(8, true);
        $hash = $hasher->hash('test12345');
        $this->assertInternalType('string', $hasher->upgrade('test12345', $hash));
    }
}

