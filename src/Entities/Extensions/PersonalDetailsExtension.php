<?php

namespace Base\User\Entities\Extensions;

use Base\Core\Extension\ExtensionInterface;
use Base\User\Entities\PersonalDetails;

class PersonalDetailsExtension implements ExtensionInterface
{
    public function getKey()
    {
        return 'personalDetails';
    }

    public function normalize($serializer, $object, $format = null, array $context = [])
    {
        $properties = $object->toArray();

        if ($format === 'json') {
            $normalized = [
                'first_name' => $properties['firstName'],
                'last_name' => $properties['lastName'],
                'user_email' => $properties['email'],
                'housenumber' => $properties['houseNumber'],
                'street' => $properties['street'],
                'town' => $properties['area'],
                'city' => $properties['city'],
                'county' => $properties['county'],
                'postcode' => $properties['postcode'],
                'telephone' => $properties['phoneNumber'],
            ];

            if (!empty($properties['dateOfBirth'])) {
                $normalized['dob'] = $properties['dateOfBirth']->format('Y-m-j');
            }
            else {
                $normalized['dob'] = null;
            }

            return $normalized;
        }

        return $properties;
    }

    public function denormalize($serializer, $data, $format = null, array $context = [])
    {
        if ($format === 'json') {
            if (!is_null($data['dob'])) {
                $dateOfBirth = new \DateTime($data['dob'], new \DateTimeZone('UTC'));
            }
            else {
                $dateOfBirth = null;
            }

            $data = [
                'firstName' => $data['first_name'],
                'lastName' => $data['last_name'],
                'dateOfBirth' => $dateOfBirth,
                'houseNumber' => $data['housenumber'],
                'street' => $data['street'],
                'area' => $data['town'],
                'city' => $data['city'],
                'county' => $data['county'],
                'postcode' => $data['postcode'],
                'phoneNumber' => $data['telephone'],
            ];
        }

        $denormalized = PersonalDetails::createFromArray($data);

        return $denormalized;
    }
}
