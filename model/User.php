<?php

namespace model;

class User
{
    private $id;
    private $email;
    private $enabled;
    private $firstName;
    private $lastName;
    private $mobilePhone;
    private $imageUrl;
    private $password;
    private $lastLogin;
    private $role;
    private $address;
    private $personal;


    public function __construct()
    {
        $this->enabled = 1;
        $this->imageUrl = "../../web/assets/images/default.jpg";
        $this->lastLogin = date("Y-m-d H:i:s");
        $this->address = 0;
        $this->personal = 1;
        $this->firstName = "User";
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function setLastLogin()
    {
        $this->lastLogin = date("Y-m-d H:i:s");
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getPersonal()
    {
        return $this->personal;
    }

    public function setPersonal($personal)
    {
        $this->personal = $personal;
    }


}