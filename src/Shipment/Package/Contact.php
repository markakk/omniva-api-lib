<?php

namespace Mijora\Omniva\Shipment\Package;

use Mijora\Omniva\Helper;

class Contact
{
    /**
     * @var string
     */
    private $personName;
    
    /**
     * @var string
     */
    private $companyName;

    /**
     * Value is used on label as sender name in case this needs to be different to the partner name.
     * This value is also used in notification messages to sender. OMX
     * 
     * @var string
     */
    private $altName;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getPersonName()
    {
        return $this->personName;
    }

    /**
     * @param string $personName
     * @return Contact
     */
    public function setPersonName($personName)
    {
        $this->personName = $personName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return Contact
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return Contact
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     * @return Contact
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getAltName()
    {
        return $this->altName;
    }

    /**
     * Value is used on label as sender name in case this needs to be different to the partner name.
     * This value is also used in notification messages to sender.
     * OMX Only
     * 
     * @param string $altName Name to display on labels. Will be trimmed to 50 symbols
     * @return Contact
     */
    public function setAltName($altName)
    {
        $this->altName = mb_substr($altName, 0, 50);
        return $this;
    }

    /**
     * @return array
     */
    public function getAddresseeForOmx($delivery_channel = null)
    {
        $addressee = [
            'address' => $this->getAddress()->getAddressForOmx($delivery_channel),
            'contactEmail' => Helper::escapeForApi($this->getEmail(), Helper::ESCAPE_FOR_API_TYPE_EMAIL),
            'contactMobile' => Helper::escapeForApi($this->getMobile()),
            'personName' => $this->getPersonName(),
        ];

        if ($this->getAltName()) {
            $addressee['altName'] = $this->getAltName();
        }

        if ($this->getPhone()) {
            $addressee['contactPhone'] = Helper::escapeForApi($this->getPhone());
        }

        if ($this->getCompanyName()) {
            $addressee['companyName'] = $this->getCompanyName();
            // if companyName is used need to remove personName as both cant be present
            unset($addressee['personName']);
        }

        return $addressee;
    }
}