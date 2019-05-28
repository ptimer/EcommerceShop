<?php


namespace model\database;

use model\database\Connect\Connection;
use model\Slider;
use PDO;
use PDOException;


class SliderDao
{

   //Делаем синглтон
    private static $instance;
    private $pdo;

    //Определяем запросы, как константы

    const GET_SLIDER_BY_ID = "SELECT * FROM slider WHERE p.id = ?";

    const GET_ALL_SLIDERS = "SELECT * FROM slider";

    const CREATE_SLIDER_INFO = "INSERT INTO slider(image_url,href,title) VALUES (?, ?, ?)";

    const EDIT_SLIDER_INFO = "UPDATE slider SET image_url = ?, href = ?, title = ? WHERE id = ?";

    const DELETE_SLIDER = "DELETE FROM slider WHERE id = ?";


    private function __construct()
    {

        $this->pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance()
    {

        if (self::$instance === null) {
            self::$instance = new SliderDao();
        }

        return self::$instance;
    }

    function createNewSlider(Slider $slider)
    {
        $this->pdo->beginTransaction();
        try {

            $title = $slider->getTitle();
            $image = $slider->getImage();
            $href = $slider->getHref();
            $statement = $this->pdo->prepare(self::CREATE_SLIDER_INFO);
            $statement->execute(array($image, $href, $title));
            $sliderId = $this->pdo->lastInsertId();
            $this->pdo->commit();

            return $sliderId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    function EditSlider(Slider $slider)
    {
        $this->pdo->beginTransaction();
        try {

            $title = $slider->getTitle();
            $image = $slider->getImage();
            $href = $slider->getHref();
            $id = $slider->getId();
            $statement = $this->pdo->prepare(self::EDIT_SLIDER_INFO);
            $statement->execute(array($image, $href, $title, $id));
            $sliderId = $this->pdo->lastInsertId();
            $this->pdo->commit();

            return $sliderId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    function getAllSliders()
    {
        $statement = $this->pdo->prepare(self::GET_ALL_SLIDERS);
        $statement->execute();

        $sliders = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $sliders;
    }

    function deleteSlider($id)
    {
      $statement = $this->pdo->prepare(self::DELETE_SLIDER);
      $statement->execute(array($id));
    }
}
