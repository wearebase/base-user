<?php

namespace Base\User\Passwords;

interface HasherInterface
{
    public function hash($password);
    public function verify($password, $hash);
    public function upgrade($password, $hash);
}
