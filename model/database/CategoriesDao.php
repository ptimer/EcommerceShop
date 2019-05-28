<?php


namespace model\database;

use model\Category;
use model\database\Connect\Connection;
use PDO;

class CategoriesDao
{

    //Делаем синглтон
    private static $instance;
    private $pdo;

    //Определяем запросы, как константы
    const CREATE_CAT = "INSERT INTO categories (name, supercategory_id) VALUES (?, ?)";

    const GET_ALL_CATS = "SELECT * FROM categories";

    const GET_ALL_CATS_ADMIN = "SELECT c.id, c.name, sc.name AS supercatname FROM categories c 
                          LEFT JOIN supercategories sc ON c.supercategory_id = sc.id";

    const GET_CAT_BY_ID = "SELECT * FROM categories WHERE id = ?";

    const EDIT_CAT = "UPDATE categories SET name = ?, supercategory_id = ? WHERE id = ?";

    const DELETE_CAT = "DELETE FROM categories WHERE id = ?";


    private function __construct()
    {
        $this->pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new CategoriesDao();
        }

        return self::$instance;
    }


    function createCategory(Category $category)
    {

        $statement = $this->pdo->prepare(self::CREATE_CAT);
        $statement->execute(array(
            $category->getName(),
            $category->getSupercategoryId()));

        return $this->pdo->lastInsertId();
    }

    function getAllCategories()
    {
        $statement = $this->pdo->prepare(self::GET_ALL_CATS);
        $statement->execute();
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }

    function getAllCategoriesAdmin()
    {

        $statement = $this->pdo->prepare(self::GET_ALL_CATS_ADMIN);
        $statement->execute();
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }

    function getCategoryById($catId)
    {
        $statement = $this->pdo->prepare(self::GET_CAT_BY_ID);
        $statement->execute(array($catId));
        $category = $statement->fetch();

        return $category;
    }

    function editCategory(Category $cat)
    {
        $statement = $this->pdo->prepare(self::EDIT_CAT);
        $statement->execute(array($cat->getName(), $cat->getSupercategoryId(), $cat->getId()));

        return true;
    }

    function deleteCategory($catId)
    {
        $statement = $this->pdo->prepare(self::DELETE_CAT);
        $statement->execute(array($catId));

        return true;
    }
}