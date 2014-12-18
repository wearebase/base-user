<?php

namespace Base\User\Entities;

class User
{
    use \Base\Core\Extension\ExtensionTrait;
    use \Base\Core\Extension\ExtensionMagicTrait;

    protected $id;
    protected $email;
    protected $password;
    protected $confirm;
    protected $roles = [];

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;
    }

    public function getConfirm()
    {
        return $this->confirm;
    }

    public function isPasswordMatching()
    {
        return $this->password === $this->confirm;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return $this->roles;
    }
}
