<?php

namespace Base\User\Passwords;

class SimpleHasher implements HasherInterface
{
    protected $algo;
    protected $options = [];

    public function __construct($algo, array $options = [])
    {
        if ($algo !== PASSWORD_DEFAULT && $algo !== PASSWORD_BCRYPT) {
            throw new \Exception('Algorithm is not valid');
        }

        $this->algo = $algo;
        $this->options = $options;
    }

    public function hash($password)
    {
        return password_hash($password, $this->algo, $this->options);
    }

    public function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function upgrade($password, $hash)
    {
        if (password_needs_rehash($hash, $this->algo, $this->options)) {
            return $this->hash($password);
        }

        return false;
    }
}
