<?php


namespace model\database;

use model\database\Connect\Connection;
use model\SubCategory;

class SubCategoriesDao
{


    private static $instance;
    private $pdo;



    const CREATE_SUBCAT = "INSERT INTO subcategories (name, category_id) VALUES (?, ?)";

    const GET_ALL_SUBCATS = "SELECT * FROM subcategories";

    const GET_SUBCAT_NAME = "SELECT name FROM subcategories WHERE id = ?";

    const GET_ALL_SUBCATS_ADMIN = "SELECT sc.id, sc.name, c.name AS catname FROM subcategories sc 
                                    LEFT JOIN categories c ON sc.category_id = c.id";

    const GET_ALL_SUBCATS_WITHOUT_PRODUCTS = "SELECT sc.* FROM subcategories sc 
                                          WHERE NOT EXISTS(SELECT * FROM products p 
                                          WHERE p.subcategory_id = sc.id)";

    const GET_SUBCAT_BY_ID = "SELECT * FROM subcategories WHERE id = ?";

    const EDIT_SUBCAT = "UPDATE subcategories SET name = ?, category_id = ? WHERE id = ?";

    const DELETE_SUBCAT = "DELETE FROM subcategories WHERE id = ?";



    private function __construct()
    {

        $this->pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance()
    {

        if (self::$instance === null) {
            self::$instance = new SubCategoriesDao();
        }

        return self::$instance;
    }


    function createSubCategory(SubCategory $subCategory)
    {

        $statement = $this->pdo->prepare(self::CREATE_SUBCAT);
        $statement->execute(array(
            $subCategory->getName(),
            $subCategory->getCategoryId()));

        return $this->pdo->lastInsertId();
    }


    function getAllSubCategories()
    {

        $statement = $this->pdo->prepare(self::GET_ALL_SUBCATS);
        $statement->execute();
        $subcategories = $statement->fetchAll();

        return $subcategories;
    }

    function getAllSubCategoriesWithoutProducts()
    {

        $statement = $this->pdo->prepare(self::GET_ALL_SUBCATS_WITHOUT_PRODUCTS);
        $statement->execute();
        $subcategories = $statement->fetchAll();

        return $subcategories;
    }

    function getAllSubCategoriesAdmin()
    {

        $statement = $this->pdo->prepare(self::GET_ALL_SUBCATS_ADMIN);
        $statement->execute();
        $subcategories = $statement->fetchAll();

        return $subcategories;
    }

    function getSubCategoryName($subId)
    {

        $statement = $this->pdo->prepare(self::GET_SUBCAT_NAME);
        $statement->execute(array($subId));
        $subcategory = $statement->fetch();

        return $subcategory[0];
    }

    function getSubCategoryById($subcatId)
    {
        $statement = $this->pdo->prepare(self::GET_SUBCAT_BY_ID);
        $statement->execute(array($subcatId));
        $category = $statement->fetch();

        return $category;
    }

    function editSubCategory(SubCategory $subcat)
    {
        $statement = $this->pdo->prepare(self::EDIT_SUBCAT);
        $statement->execute(array($subcat->getName(), $subcat->getCategoryId(), $subcat->getId()));

        return true;
    }

    function deleteSubCategory($subcatId)
    {
        $statement = $this->pdo->prepare(self::DELETE_SUBCAT);
        $statement->execute(array($subcatId));

        return true;
    }
}