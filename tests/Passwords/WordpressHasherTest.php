<?php

namespace Base\User\Passwords;

class WordpressHasherTest extends \PHPUnit_Framework_TestCase
{
    public function testMd5Legacy()
    {
        $hasher = new WordpressHasher();
        $this->assertTrue($hasher->verify('test12345', md5('test12345')));
        $this->assertFalse($hasher->verify('test12345', md5('test12346')));
    }
}

