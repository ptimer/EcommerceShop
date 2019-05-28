<?php


namespace model;

class ProductSpecification
{
    private $id;
    private $value;
    private $subcatSpecId;
    private $productId;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getSubcatSpecId()
    {
        return $this->subcatSpecId;
    }

    public function setSubcatSpecId($subcatSpecId)
    {
        $this->subcatSpecId = $subcatSpecId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }
}