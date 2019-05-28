<?php


namespace model;


class Category
{
    private $id;
    private $name;
    private $supercategory_id;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSupercategoryId()
    {
        return $this->supercategory_id;
    }

    public function setSupercategoryId($supercategory_id)
    {
        $this->supercategory_id = $supercategory_id;
    }


}