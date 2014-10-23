<?php

namespace Base\User\Entities;

class PersonalDetails
{
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $dateOfBirth;
    protected $houseNumber;
    protected $street;
    protected $area;
    protected $city;
    protected $county;
    protected $postcode;
    protected $phoneNumber;

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setDateOfBirth(\DateTime $dateOfBirth = null)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
    }

    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setArea($area)
    {
        $this->area = $area;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCounty($county)
    {
        $this->county = $county;
    }

    public function getCounty()
    {
        return $this->county;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = strtoupper($postcode);
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function toArray()
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'dateOfBirth' => $this->dateOfBirth,
            'houseNumber' => $this->houseNumber,
            'street' => $this->street,
            'area' => $this->area,
            'city' => $this->city,
            'county' => $this->county,
            'postcode' => $this->postcode,
            'phoneNumber' => $this->phoneNumber,
        ];
    }

    public static function createFromArray(array $properties)
    {
        $personalDetails = new self();

        foreach ($properties as $property => $value) {
            $method = 'set' . ucfirst($property);

            if (method_exists($personalDetails, $method)) {
                $personalDetails->$method($value);
            }
        }

        return $personalDetails;
    }
}
