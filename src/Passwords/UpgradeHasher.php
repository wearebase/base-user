<?php

namespace Base\User\Passwords;

class UpgradeHasher implements HasherInterface
{
    protected $hashers;

    public function __construct($hashers = [])
    {
        if (count($hashers) < 2) {
            throw new \Exception('At least two hashers must be provided');
        }

        foreach ($hashers as $hasher) {
            if (!(is_a($hasher, 'Base\\User\\Passwords\\HasherInterface'))) {
                throw new \Exception('Hashers must implment HasherInterface');
            }
        }

        $this->hashers = array_values($hashers);
    }

    public function hash($password)
    {
        return $this->hashers[0]->hash($password);
    }

    public function verify($password, $hash)
    {
        foreach ($this->hashers as $hasher) {
            if ($hasher->verify($password, $hash)) {
                return true;
            }
        }

        return false;
    }

    public function upgrade($password, $hash)
    {
        return $this->hashers[0]->upgrade($password, $hash);
    }
}
