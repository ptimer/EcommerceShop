<?php


namespace model\database;

use model\database\Connect\Connection;
use model\SubcatSpecification;
use PDO;

class SubcatSpecificationsDao
{


    private static $instance;
    private $pdo;


    const CREATE_SPEC = "INSERT INTO subcat_specifications (name, subcategory_id) VALUES (?, ?)";

    const GET_ALL_SPEC_FOR_SUBCAT = "SELECT * FROM subcat_specifications WHERE subcategory_id = ?";

    const GET_ALL_SPECS_ADMIN = "SELECT scs.id, scs.name, sc.name AS subcat_name FROM subcat_specifications scs
                                LEFT JOIN subcategories sc ON scs.subcategory_id = sc.id";

    const GET_SPEC_BY_ID = "SELECT * FROM subcat_specifications WHERE id = ?";

    const EDIT_SPEC = "UPDATE subcat_specifications SET name = ?, subcategory_id = ? WHERE id = ?";

    const DELETE_SPEC = "DELETE FROM subcat_specifications WHERE id = ?";



    private function __construct()
    {

        $this->pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance()
    {

        if (self::$instance === null) {
            self::$instance = new SubcatSpecificationsDao();
        }

        return self::$instance;
    }



    function createSpecification(SubcatSpecification $specification)
    {

        $statement = $this->pdo->prepare(self::CREATE_SPEC);
        $statement->execute(array(
            $specification->getName(),
            $specification->getSubcategoryId()));

        return $this->pdo->lastInsertId();
    }


    function getAllSpecificationsForSubcategory($subcatId)
    {

        $statement = $this->pdo->prepare(self::GET_ALL_SPEC_FOR_SUBCAT);
        $statement->execute(array($subcatId));

        $specs = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $specs;
    }

    function getAllSubcategorySpecificationsAdmin()
    {
        $statement = $this->pdo->prepare(self::GET_ALL_SPECS_ADMIN);
        $statement->execute();

        $specs = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $specs;
    }

    function getSubcatSpecById($specId)
    {
        $statement = $this->pdo->prepare(self::GET_SPEC_BY_ID);
        $statement->execute(array($specId));
        $category = $statement->fetch();

        return $category;
    }

    function editSubcatSpec(SubcatSpecification $spec)
    {
        $statement = $this->pdo->prepare(self::EDIT_SPEC);
        $statement->execute(array($spec->getName(), $spec->getSubcategoryId(), $spec->getId()));

        return true;
    }

    function deleteSubcatSpec($specId)
    {
        $statement = $this->pdo->prepare(self::DELETE_SPEC);
        $statement->execute(array($specId));

        return true;
    }
}