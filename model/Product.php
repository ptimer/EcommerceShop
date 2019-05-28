<?php


namespace model;


class Product
{
    private $id;
    private $title;
    private $description;
    private $price;
    private $quantity;
    private $visible;
    private $createdAt;
    private $subcategoryId;

    public function __construct()
    {
        $this->visible = 1;
        $this->createdAt = date("Y-m-d H:i:s");
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getVisible()
    {
        return $this->visible;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getSubcategoryId()
    {
        return $this->subcategoryId;
    }

    public function setSubcategoryId($subcategoryId)
    {
        $this->subcategoryId = $subcategoryId;
    }


}