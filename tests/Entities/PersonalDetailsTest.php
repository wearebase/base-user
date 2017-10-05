<?php

namespace Base\User\Entities;

use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\DefaultTranslator;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\YamlFileLoader;
use Symfony\Component\Validator\Validator;

class PersonalDetailsTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new Validator(
            new ClassMetadataFactory(new YamlFileLoader(__DIR__ . '/../../resources/validation.yml')),
            new ConstraintValidatorFactory(),
            new DefaultTranslator(),
            'validators',
            []
        );
    }

    public function testCreateFromArray()
    {
        $dateOfBirth = new \DateTime('1990-05-25');

        $personalDetails = PersonalDetails::createFromArray([
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

        $this->assertEquals('Personal', $personalDetails->getFirstName());
        $this->assertEquals('DataUser', $personalDetails->getLastName());
        $this->assertEquals($dateOfBirth, $personalDetails->getDateOfBirth());
        $this->assertEquals('01202 000001', $personalDetails->getPhoneNumber());
        $this->assertEquals('1', $personalDetails->getHouseNumber());
        $this->assertEquals('Street', $personalDetails->getStreet());
        $this->assertEquals('Bournemouth', $personalDetails->getArea());
        $this->assertEquals('Bournemouth', $personalDetails->getCity());
        $this->assertEquals('Dorset', $personalDetails->getCounty());
        $this->assertEquals('BH1 1AA', $personalDetails->getPostcode());
    }

    public function testCreateWithNullDateOfBirth()
    {
        $personalDetails = PersonalDetails::createFromArray([
            'firstName' => 'Personal',
            'lastName' => 'DataUser',
            'dateOfBirth' => null,
            'phoneNumber' => '01202 000001',
            'houseNumber' => '1',
            'street' => 'Street',
            'area' => 'Bournemouth',
            'city' => 'Bournemouth',
            'county' => 'Dorset',
            'postcode' => 'BH1 1AA',
        ]);

        $this->assertNull($personalDetails->getDateOfBirth());
    }

    /**
     * @dataProvider postCodeProvider
     */
    public function testPostCodeValidation($postCode, $errorsPresent)
    {
        $dateOfBirth = new \DateTime('1990-05-25');

        $personalDetails = PersonalDetails::createFromArray([
            'firstName' => 'Personal',
            'lastName' => 'DataUser',
            'dateOfBirth' => $dateOfBirth,
            'phoneNumber' => '01202 000001',
            'houseNumber' => '1',
            'street' => 'Street',
            'area' => 'Bournemouth',
            'city' => 'Bournemouth',
            'county' => 'Dorset',
            'postcode' => $postCode,
        ]);

        $this->assertEquals($errorsPresent, (bool) count($this->validator->validate($personalDetails)));
    }

    public function postCodeProvider()
    {
        return [
            ['', true],
            [null, true],
            ['CW3 9SS', false],
            ['WCC 7LT', false],
            ['WC2H', false],
            ['7250', false],
        ];
    }
}
