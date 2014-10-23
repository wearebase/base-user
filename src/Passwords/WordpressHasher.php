<?php

namespace Base\User\Passwords;

class WordpressHasher extends PortableHasher implements HasherInterface
{
    public function __construct()
    {
        parent::__construct(8, true);
    }

    public function verify($password, $hash)
    {
        if (strlen($hash) <= 32) {
            return $hash == md5($password);
        }

        return parent::verify($password, $hash);
    }
}
