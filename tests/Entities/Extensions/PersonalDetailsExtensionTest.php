<?php

namespace Base\User\Entities\Extensions;

use Base\User\Entities;

class PersonalDetailsExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->extension = new PersonalDetailsExtension();
        $this->serializer = new \Symfony\Component\Serializer\Serializer();
    }

    public function testKey()
    {
        $this->assertInternalType('string', $this->extension->getKey());
    }

    public function testNormalization()
    {
        $dateOfBirth = new \DateTime('1990-05-25');

        $personalDetails = Entities\PersonalDetails::createFromArray([
            'firstName' => 'Personal',
            'lastName' => 'DataUser',
            'dateOfBirth' => $dateOfBirth,
            'phoneNumber' => '01202 000001',
            'houseNumber' => '1',
            'street' => 'Street',
            'area' => 'Bournemouth',
            'city' => 'Bournemouth',
            'county' => 'Dorset',
            'postcode' => 'BH1 1AA',
        ]);

        $normalized = $this->extension->normalize($this->serializer, $personalDetails);

        $this->assertEquals('Personal', $normalized['firstName']);
        $this->assertEquals('DataUser', $normalized['lastName']);
        $this->assertEquals($dateOfBirth, $normalized['dateOfBirth']);
        $this->assertEquals('01202 000001', $normalized['phoneNumber']);
        $this->assertEquals('1', $normalized['houseNumber']);
        $this->assertEquals('Street', $normalized['street']);
        $this->assertEquals('Bournemouth', $normalized['area']);
        $this->assertEquals('Bournemouth', $normalized['city']);
        $this->assertEquals('Dorset', $normalized['county']);
        $this->assertEquals('BH1 1AA', $normalized['postcode']);
    }

    public function testDenormalization()
    {
        $normalized = $this->getNormalized();
        $personalDetails = $this->extension->denormalize($this->serializer, $normalized);

        $this->assertEquals('Personal', $personalDetails->getFirstName());
        $this->assertEquals('DataUser', $personalDetails->getLastName());
        $this->assertEquals($normalized['dateOfBirth'], $personalDetails->getDateOfBirth());
        $this->assertEquals('01202 000001', $personalDetails->getPhoneNumber());
        $this->assertEquals('1', $personalDetails->getHouseNumber());
        $this->assertEquals('Street', $personalDetails->getStreet());
        $this->assertEquals('Bournemouth', $personalDetails->getArea());
        $this->assertEquals('Bournemouth', $personalDetails->getCity());
        $this->assertEquals('Dorset', $personalDetails->getCounty());
        $this->assertEquals('BH1 1AA', $personalDetails->getPostcode());
    }

    public function testNormalizationJson()
    {
        $dateOfBirth = new \DateTime('1990-05-25');

        $personalDetails = Entities\PersonalDetails::createFromArray([
            'firstName' => 'Personal',
            'lastName' => 'DataUser',
            'email' => 'user@example.com',
            'dateOfBirth' => $dateOfBirth,
            'phoneNumber' => '01202 000001',
            'houseNumber' => '1',
            'street' => 'Street',
            'area' => 'Bournemouth',
            'city' => 'Bournemouth',
            'county' => 'Dorset',
            'postcode' => 'BH1 1AA',
        ]);

        $normalized = $this->extension->normalize($this->serializer, $personalDetails, 'json');

        $this->assertEquals($this->getNormalizedForJson(), $normalized);
    }

    public function testDenormalizationJson()
    {
        $normalized = $this->getNormalizedForJson();
        $personalDetails = $this->extension->denormalize($this->serializer, $normalized, 'json');

        $this->assertEquals('Personal', $personalDetails->getFirstName());
        $this->assertEquals('DataUser', $personalDetails->getLastName());
        $this->assertEquals('1990-05-25', $personalDetails->getDateOfBirth()->format('Y-m-j'));
        $this->assertEquals('01202 000001', $personalDetails->getPhoneNumber());
        $this->assertEquals('1', $personalDetails->getHouseNumber());
        $this->assertEquals('Street', $personalDetails->getStreet());
        $this->assertEquals('Bournemouth', $personalDetails->getArea());
        $this->assertEquals('Bournemouth', $personalDetails->getCity());
        $this->assertEquals('Dorset', $personalDetails->getCounty());
        $this->assertEquals('BH1 1AA', $personalDetails->getPostcode());
    }

    private function getNormalized()
    {
        return [
            'firstName' => 'Personal',
            'lastName' => 'DataUser',
            'dateOfBirth' => new \DateTime('1990-05-25'),
            'phoneNumber' => '01202 000001',
            'houseNumber' => '1',
            'street' => 'Street',
            'area' => 'Bournemouth',
            'city' => 'Bournemouth',
            'county' => 'Dorset',
            'postcode' => 'BH1 1AA',
        ];
    }

    private function getNormalizedForJson()
    {
        return [
            'first_name' => 'Personal',
            'last_name' => 'DataUser',
            'user_email' => 'user@example.com',
            'dob' => '1990-05-25',
            'telephone' => '01202 000001',
            'housenumber' => '1',
            'street' => 'Street',
            'town' => 'Bournemouth',
            'city' => 'Bournemouth',
            'county' => 'Dorset',
            'postcode' => 'BH1 1AA',
        ];
    }
}
