<?php

namespace Base\User\Passwords;

class SimpleHasherTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidAlgorithm()
    {
        $this->setExpectedException('Exception');
        $hasher = new SimpleHasher('no_algorithm');
    }

    public function testHashAndVerify()
    {
        $hasher = new SimpleHasher(PASSWORD_BCRYPT, []);
        $hash = $hasher->hash('test12345');
        $this->assertTrue($hasher->verify('test12345', $hash));
        $this->assertFalse($hasher->verify('test12346', $hash));
    }

    public function testUpgrade()
    {
        $legacyHasher = new SimpleHasher(PASSWORD_DEFAULT, ['cost' => 4]);
        $legacyHash = $legacyHasher->hash('test123456');
        $newHasher = new SimpleHasher(PASSWORD_DEFAULT, ['cost' => 5]);
        $this->assertFalse($legacyHasher->upgrade('test12345', $legacyHash));
        $this->assertInternalType('string', $newHasher->upgrade('test12345', $legacyHash));
    }
}

