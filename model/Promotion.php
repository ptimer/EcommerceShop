<?php
namespace model;
class Promotion
{
    private $id;
    private $percent;
    private $start_date;
    private $end_date;
    private $product_id;

    public function __construct($percent, $start_date, $end_date, $product_id)
    {
        $this->percent = $percent;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->product_id = $product_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPercent()
    {
        return $this->percent;
    }

    public function setPercent($percent)
    {
        $this->percent = $percent;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }
}