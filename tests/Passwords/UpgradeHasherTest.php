<?php

namespace Base\User\Passwords;

class UpgradeHasherTest extends \PHPUnit_Framework_TestCase
{
    public function testLackOfHashers()
    {
        $this->setExpectedException('Exception');

        $hasher = new UpgradeHasher([new NullHasher()]);
    }

    public function testNotImplementingHasherInterface()
    {
        $this->setExpectedException('Exception');

        $hasher = new UpgradeHasher([
            new \StdClass(),
            new \StdClass(),
        ]);
    }

    public function testHashAndVerfiy()
    {
        $hasher = new UpgradeHasher([
            new SimpleHasher(PASSWORD_BCRYPT, ['cost' => 4]),
            new WordpressHasher(8, true),
        ]);

        $hash = $hasher->hash('test12345');

        $this->assertTrue($hasher->verify('test12345', $hash));
        $this->assertFalse($hasher->verify('test12346', $hash));
    }

    public function testUpgrade()
    {
        $legacyHasher = new WordpressHasher(8, true);
        $legacyHash = $legacyHasher->hash('test12345');

        $newHasher = new SimpleHasher(PASSWORD_BCRYPT, ['cost' => 4]);
        $newHash = $newHasher->hash('test12345');

        $hasher = new UpgradeHasher([$newHasher, $legacyHasher]);

        $this->assertFalse($hasher->upgrade('test12345', $newHash));
        $this->assertInternalType('string', $hasher->upgrade('test12345', $legacyHash));
    }
}

