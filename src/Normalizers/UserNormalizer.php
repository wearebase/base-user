<?php

namespace Base\User\Normalizers;

use Base\User\Entities\User;

use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserNormalizer extends SerializerAwareNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [
            'email' => $object->getEmail(),
            'password' => $object->getPassword(),
        ];

        $data = array_merge($data, $this->serializer->normalize(
            $object->getExtensions(),
            $format,
            $context
        ));

        if ($format === 'mongo' && $object->getId()) {
            $data['_id'] = $object->getId();
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null)
    {
        return get_class($data) === 'Base\\User\\Entities\\User';
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        if (isset($data['confirm'])) {
            $user->setConfirm($data['confirm']);
        }

        $user->setExtensions($this->serializer->denormalize(
            $data,
            'Base\\Core\\Extension\\ExtensionCollection',
            $format,
            $context
        ));

        if ($format === 'mongo' && isset($data['_id'])) {
            $user->setId($data['_id']);
        }

        return $user;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === 'Base\\User\\Entities\\User';
    }
}
