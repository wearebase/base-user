<?php

namespace Base\User\Passwords;

class NullHasher implements HasherInterface
{
    public function hash($password)
    {
        return $password;
    }

    public function verify($password, $hash)
    {
        return $password === $hash;
    }

    public function upgrade($password, $hash)
    {
        return $hash;
    }
}
