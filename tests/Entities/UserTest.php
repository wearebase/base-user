<?php

namespace Base\User\Entities;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $user = new User();
        $user->setId('12345');
        $user->setEmail('example@devba.se');
        $user->setPassword('password1');
        $user->setConfirm('password2');

        $this->assertEquals('12345', $user->getId());
        $this->assertEquals('example@devba.se', $user->getEmail());
        $this->assertEquals('password1', $user->getPassword());
        $this->assertEquals('password2', $user->getConfirm());
    }

    public function testIsPasswordMatching()
    {
        $user = new User();
        $user->setPassword('password1');
        $user->setConfirm('password2');
        $this->assertFalse($user->isPasswordMatching());

        $user = new User();
        $user->setPassword('password1');
        $user->setConfirm('password1');
        $this->assertTrue($user->isPasswordMatching());
    }

    public function testRegistrationValidation()
    {
        $validator = new \Symfony\Component\Validator\Validator(
            new \Symfony\Component\Validator\Mapping\ClassMetadataFactory(
                new \Symfony\Component\Validator\Mapping\Loader\YamlFilesLoader([
                    __DIR__ . '/../../resources/validation.yml',
                ])
            ),
            new \Symfony\Component\Validator\ConstraintValidatorFactory(),
            new \Symfony\Component\Validator\DefaultTranslator(),
            'validators',
            array()
        );

        // Blank email address
        $user = new User();
        $errors = $validator->validate($user, 'registration');
        $this->assertNotCount(0, $errors);
        $this->assertEquals('validation.email.blank', $errors[0]->getMessage());

        // Invalid email address
        $user = new User();
        $user->setEmail('invalid_email');
        $errors = $validator->validate($user, 'registration');
        $this->assertNotCount(0, $errors);
        $this->assertEquals('validation.email.invalid', $errors[0]->getMessage());

        // Blank password
        $user = new User();
        $user->setEmail('example@devba.se');
        $errors = $validator->validate($user, 'registration');
        $this->assertNotCount(0, $errors);
        $this->assertEquals('validation.password.blank', $errors[0]->getMessage());

        // Passwords don't match
        $user = new User();
        $user->setEmail('example@devba.se');
        $user->setPassword('password');
        $user->setConfirm('passw0rd');
        $errors = $validator->validate($user, 'registration');
        $this->assertNotCount(0, $errors);
        $this->assertEquals('validation.password.mismatch', $errors[0]->getMessage());
    }
}
