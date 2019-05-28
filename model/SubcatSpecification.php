<?php


namespace model;


class SubcatSpecification
{
    private $id;
    private $name;
    private $subcategory_id;

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

    public function getSubcategoryId()
    {
        return $this->subcategory_id;
    }

    public function setSubcategoryId($subcategory_id)
    {
        $this->subcategory_id = $subcategory_id;
    }


}