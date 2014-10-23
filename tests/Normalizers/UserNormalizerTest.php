<?php

namespace Base\User\Normalizers;

use Base\User\Entities\User;

class UserNormalizerTest extends \PHPUnit_Framework_TestCase
{
    protected $serializer;

    public function setUp()
    {
        $extension = $this->getMockForAbstractClass('Base\\Core\\Extension\\AbstractExtension');
        $extension->expects($this->any())
            ->method('getKey')
            ->will($this->returnValue('favouriteStops'));
        $extensionManager = new \Base\Core\Extension\ExtensionManager([$extension]);

        $this->serializer = new \Symfony\Component\Serializer\Serializer([
            new \Base\User\Normalizers\UserNormalizer(),
            new \Base\Core\Extension\ExtensionNormalizer($extensionManager),
        ]);
    }

    public function testNormalize()
    {
        $user = new User();
        $user->setEmail('tester@devba.se');
        $user->setPassword('password');
        $user->addExtension('favouriteStops', ['3390Y4', '3390Y3']);
        $data = $this->serializer->normalize($user);
        $this->assertEquals($this->getNormalized(), $data);
    }

    public function testDenormalize()
    {
        $user = $this->serializer->denormalize($this->getNormalized(), 'Base\\User\\Entities\\User');
        $this->assertEquals('tester@devba.se', $user->getEmail());
        $this->assertEquals('password', $user->getPassword());
        $this->assertEquals(['3390Y4', '3390Y3'], $user->getExtension('favouriteStops'));
    }

    private function getNormalized()
    {
        return [
            'email' => 'tester@devba.se',
            'password' => 'password',
            'favouriteStops' => ['3390Y4', '3390Y3'],
        ];
    }
}

