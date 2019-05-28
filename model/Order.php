<?php


namespace model;


class Order
{
    private $id;
    private $user_id;
    private $created_at;
    // Статус доставки товара
    private $status;
    private $products;

    public function __construct($user_id, $products)
    {
        $this->id = microtime();
        $this->user_id = $user_id;
        $this->created_at = date("Y-m-d H:i:s");
        $this->status = 1;
        $this->products = $products;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getProducts()
    {
        return $this->products;
    }
    
    public function setProducts($products)
    {
        $this->products = $products;
    }

}