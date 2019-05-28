<?php


namespace model\database;

use model\database\Connect\Connection;
use model\Product;
use PDO;
use PDOException;


class ProductsDao
{

    //Делаем синглтон
    private static $instance;
    private $pdo;

    //Определяем запросы, как константы

    const GET_PRODUCT_BY_ID = "SELECT p.id, i.image_url, p.title, p.description, p.price, p.subcategory_id, 
                               p.visible, p.quantity, MAX(pr.percent) percent, AVG(r.rating) average 
                               FROM products p JOIN images i ON p.id = i.product_id 
                               LEFT JOIN reviews r ON p.id = r.product_id
							   LEFT JOIN promotions pr ON p.id = pr.product_id 
                               WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                               GROUP BY p.id HAVING p.visible = 1 AND p.subcategory_id IS NOT NULL AND p.id = ?";

    const GET_PRODUCT_BY_ID_ADMIN = "SELECT p.id, i.image_url, p.title, p.description, p.price, p.subcategory_id, 
                                     p.visible, p.quantity, MAX(pr.percent) percent, AVG(r.rating) average 
                                     FROM products p JOIN images i ON p.id = i.product_id 
                                     LEFT JOIN reviews r ON p.id = r.product_id
								     LEFT JOIN promotions pr ON p.id = pr.product_id 
                                     WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                                     GROUP BY p.id HAVING p.id = ?";

    const GET_MOST_RATED_PRODUCTS = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                     p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                     p.price, MAX(pr.percent) percent, 
                                     IF(MAX(pr.percent) IS NOT NULL, 
                                     p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                     FROM products p JOIN images i ON p.id = i.product_id
                                     LEFT JOIN reviews r ON p.id = r.product_id
                                     LEFT JOIN promotions pr ON p.id = pr.product_id 
                                     WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                                     GROUP BY p.id HAVING p.visible = 1 AND p.subcategory_id IS NOT NULL
                                     ORDER BY average DESC, reviewsCount DESC LIMIT 100";

    const GET_RELATED_PRODUCTS = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                     p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                     p.price, MAX(pr.percent) percent, 
                                     IF(MAX(pr.percent) IS NOT NULL, 
                                     p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                     FROM products p JOIN images i ON p.id = i.product_id
                                     LEFT JOIN reviews r ON p.id = r.product_id
                                     LEFT JOIN promotions pr ON p.id = pr.product_id 
                                     WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                                     GROUP BY p.id HAVING p.visible = 1 AND p.subcategory_id IS NOT NULL
                                     AND NOT p.id = ? AND p.subcategory_id = ?
                                     ORDER BY average DESC, reviewsCount DESC LIMIT 100";

    const GET_MOST_RECENT_PRODUCTS = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                      p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                      p.price, MAX(pr.percent) percent, IF(MAX(pr.percent) IS NOT NULL, 
                                      p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                      FROM products p JOIN images i ON p.id = i.product_id
                                      LEFT JOIN reviews r ON p.id = r.product_id
                                      LEFT JOIN promotions pr ON p.id = pr.product_id 
                                      WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL 
                                      GROUP BY p.id HAVING p.visible = 1 AND p.subcategory_id IS NOT NULL
                                      ORDER BY p.created_at DESC, average DESC, reviewsCount DESC 
                                      LIMIT 100";

    const GET_MOST_SOLD = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                           p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                           p.price, MAX(pr.percent) percent, 
                           IF(MAX(pr.percent) IS NOT NULL, 
                           p.price - MAX(pr.percent)/100*p.price, p.price) price_fin,
                           SUM(DISTINCT op.quantity) sold, o.status
                           FROM products p JOIN images i ON p.id = i.product_id
                           LEFT JOIN reviews r ON p.id = r.product_id
                           LEFT JOIN order_products op ON p.id = op.product_id
                           LEFT JOIN orders o ON o.id = op.order_id 
                           LEFT JOIN promotions pr ON p.id = pr.product_id 
                           WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                           GROUP BY p.id HAVING p.visible = 1 AND p.subcategory_id IS NOT NULL
                           ORDER BY o.status = 3 DESC, sold DESC, average DESC LIMIT 100";

    const SEARCH_PRODUCTS = "SELECT p.id, p.title, p.visible, MIN(i.image_url) image_url, p.subcategory_id, 
                             ROUND(IF(MAX(pr.percent) IS NOT NULL, 
                             p.price - MAX(pr.percent)/100*p.price, p.price), 2) price
                             FROM products p JOIN images i ON p.id = i.product_id
                             LEFT JOIN promotions pr ON p.id = pr.product_id 
                             WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                             GROUP BY p.id HAVING p.visible = 1 
                             AND p.subcategory_id IS NOT NULL AND title LIKE ? LIMIT 3";

    const SEARCH_PRODUCTS_NO_LIMIT = "SELECT p.id, p.title, p.visible, p.price, MIN(i.image_url) image_url, 
                                      p.subcategory_id, MAX(pr.percent) percent, AVG(r.rating) average,
                                      COUNT(DISTINCT r.id) reviewsCount
                                      FROM products p JOIN images i ON p.id = i.product_id
                                      LEFT JOIN reviews r ON p.id = r.product_id
                                      LEFT JOIN promotions pr ON p.id = pr.product_id 
                                      WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                                      GROUP BY p.id HAVING p.visible = 1 
                                      AND p.subcategory_id IS NOT NULL AND title LIKE ?";

    const GET_ALL_PRODUCTS_ADMIN = "SELECT p.id, p.title, p.description, p.price, p.quantity, p.visible, 
                                    p.created_at, sc.name AS subcat_name, MAX(pr.percent) percent
                                    FROM products p LEFT JOIN subcategories sc ON p.subcategory_id = sc.id 
                                    LEFT JOIN promotions pr ON p.id = pr.product_id WHERE pr.start_date <= NOW() 
                                    AND pr.end_date >= NOW() OR pr.id IS NULL
                                    GROUP BY p.id
                                    ORDER BY p.created_at DESC";

    const GET_ALL_PRODUCTS_GUEST = "SELECT p.id, i.image_url, p.title, p.subcategory_id, 
                                      p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                      p.price
                                      FROM products p JOIN images i ON p.id = i.product_id
                                      LEFT JOIN reviews r ON p.id = r.product_id
                                    
                                      GROUP BY p.id HAVING p.visible = 1 AND p.subcategory_id IS NOT NULL
                                      ORDER BY p.created_at DESC, average DESC, reviewsCount DESC 
                                      ";

    const TOGGLE_VISIBILITY = "UPDATE products SET visible = ? WHERE id = ?";

    const CREATE_PRODUCT_INFO = "INSERT INTO products(title, description, price, quantity, visible, created_at,
                                  subcategory_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

    const CREATE_PRODUCT_IMAGE = "INSERT INTO images (image_url, product_id) VALUES (?, ?)";

    const CREATE_PRODUCT_SPEC = "INSERT INTO subcat_specification_value (value, subcat_spec_id, product_id)
                                            VALUES (?, ?, ?)";

    const EDIT_PRODUCT_INFO = "UPDATE products SET title = ?, description = ?, price = ?, quantity = ?, 
                                subcategory_id = ? WHERE id = ?";

    const EDIT_PRODUCT_SPEC = "UPDATE subcat_specification_value SET value = ? WHERE id = ?";

    const DELETE_PRODUCT_IMAGES = "DELETE FROM images WHERE product_id = ?";

    const DELETE_PRODUCT_SPECS = "DELETE FROM subcat_specification_value WHERE product_id = ?";

    const GET_SUBCAT_PRODUCTS_NEWEST = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                            p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                            p.price, MAX(pr.percent) percent, IF(MAX(pr.percent) IS NOT NULL, 
                                            p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                            FROM products p JOIN images i ON p.id = i.product_id
                                            LEFT JOIN reviews r ON p.id = r.product_id
                                            LEFT JOIN promotions pr ON p.id = pr.product_id 
                                            WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL 
                                            GROUP BY p.id HAVING p.subcategory_id = :sub AND p.visible = 1 
                                            AND price_fin BETWEEN :minP AND :maxP 
                                            ORDER BY p.created_at DESC, average DESC, reviewsCount DESC 
                                            LIMIT 8 OFFSET :off";

    const GET_SUBCAT_PRODUCTS_MOST_SOLD = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                            p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                            p.price, MAX(pr.percent) percent, 
                                            IF(MAX(pr.percent) IS NOT NULL, 
                                            p.price - MAX(pr.percent)/100*p.price, p.price) price_fin,
                                            SUM(DISTINCT op.quantity) sold, o.status
                                            FROM products p JOIN images i ON p.id = i.product_id
                                            LEFT JOIN reviews r ON p.id = r.product_id
                                            LEFT JOIN order_products op ON p.id = op.product_id
                                            LEFT JOIN orders o ON o.id = op.order_id 
                                            LEFT JOIN promotions pr ON p.id = pr.product_id 
                                            WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                                            GROUP BY p.id HAVING p.subcategory_id = :sub AND p.visible = 1
											AND price_fin BETWEEN :minP AND :maxP
                                            ORDER BY o.status = 3 DESC, sold DESC, average DESC LIMIT 8 OFFSET :off";

    const GET_SUBCAT_PRODUCTS_MOST_REVIEWED = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                            p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                            p.price, MAX(pr.percent) percent, 
                                            IF(MAX(pr.percent) IS NOT NULL, 
                                            p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                            FROM products p JOIN images i ON p.id = i.product_id
                                            LEFT JOIN reviews r ON p.id = r.product_id
                                            LEFT JOIN promotions pr ON p.id = pr.product_id 
                                            WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                                            GROUP BY p.id HAVING p.subcategory_id = :sub AND p.visible = 1 
                                            AND price_fin BETWEEN :minP AND :maxP
                                            ORDER BY reviewsCount DESC, average DESC LIMIT 8 OFFSET :off";

    const GET_SUBCAT_PRODUCTS_HIGHEST_RATED = "SELECT p.id, MIN(i.image_url) image_url, p.title, p.subcategory_id, 
                                            p.visible, COUNT(DISTINCT r.id) reviewsCount, AVG(r.rating) average, 
                                            p.price, MAX(pr.percent) percent, IF(MAX(pr.percent) IS NOT NULL, 
                                            p.price - MAX(pr.percent)/100*p.price, p.price) price_fin 
                                            FROM products p JOIN images i ON p.id = i.product_id
                                            LEFT JOIN reviews r ON p.id = r.product_id
                                            LEFT JOIN promotions pr ON p.id = pr.product_id 
                                            WHERE pr.start_date <= NOW() AND pr.end_date >= NOW() OR pr.id IS NULL
                                            GROUP BY p.id HAVING p.subcategory_id = :sub AND p.visible = 1 
                                            AND price_fin BETWEEN :minP AND :maxP
                                            ORDER BY average DESC, reviewsCount DESC LIMIT 8 OFFSET :off";

    private function __construct()
    {

        $this->pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance()
    {

        if (self::$instance === null) {
            self::$instance = new ProductsDao();
        }

        return self::$instance;
    }


    function createNewProduct(Product $product, $images, $specs)
    {
        $this->pdo->beginTransaction();
        try {
            //product инфо
            $title = $product->getTitle();
            $description = $product->getDescription();
            $price = $product->getPrice();
            $quantity = $product->getQuantity();
            $visible = $product->getVisible();
            $createdAt = $product->getCreatedAt();
            $subcatId = $product->getSubcategoryId();
            $statement = $this->pdo->prepare(self::CREATE_PRODUCT_INFO);
            $statement->execute(array($title, $description, $price, $quantity, $visible, $createdAt, $subcatId));
            $productId = $this->pdo->lastInsertId();

            //изображения
            foreach ($images as $image) {
                $statement = $this->pdo->prepare(self::CREATE_PRODUCT_IMAGE);
                $statement->execute(array($image, $productId));
            }

            //категории 
            foreach ($specs as $spec) {
                $value = $spec->getValue();
                $specId = $spec->getSubcatSpecId();

                $statement = $this->pdo->prepare(self::CREATE_PRODUCT_SPEC);
                $statement->execute(array($value, $specId, $productId));
            }

            $this->pdo->commit();

            return $productId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    function editProduct(Product $product, $images, $specs)
    {
        $this->pdo->beginTransaction();
        try {
            $productId = $product->getId();
            $title = $product->getTitle();
            $description = $product->getDescription();
            $price = $product->getPrice();
            $quantity = $product->getQuantity();
            $subcatId = $product->getSubcategoryId();
            $statement = $this->pdo->prepare(self::EDIT_PRODUCT_INFO);
            $statement->execute(array($title, $description, $price, $quantity, $subcatId, $productId));

            //изображения
            // Если изображения получены, то удалятся старые и заменятся новыми
            if (!empty($images)) {
                $statement = $this->pdo->prepare(self::DELETE_PRODUCT_IMAGES);
                $statement->execute(array($productId));
                foreach ($images as $image) {
                    $statement = $this->pdo->prepare(self::CREATE_PRODUCT_IMAGE);
                    $statement->execute(array($image, $productId));
                }
            }

            // @@@@исправлен баг с редактированием@@@@
            if(!empty($specs)){
                //категории
              if ($specs[0]['newSubcat'] == 1) {
                  // если подкатегория изменится, старая удалится и заменится новой
                  $statement = $this->pdo->prepare(self::DELETE_PRODUCT_SPECS);
                  $statement->execute(array($productId));

                  foreach ($specs[1] as $spec) {
                      if (!empty($spec)) {
                          $value = $spec->getValue();
                      } else {
                          $value = "Not specified";
                      }
                      $specId = $spec->getSubcatSpecId();

                      $statement = $this->pdo->prepare(self::CREATE_PRODUCT_SPEC);
                      $statement->execute(array($value, $specId, $productId));
                  }
              } else {
                  // если подкатегория не изменилась, обновить старые категории
                  foreach ($specs[1] as $spec) {
                      $specId = $spec->getId();
                      if (!empty($spec)) {
                          $value = $spec->getValue();
                      } else {
                          $value = "Not specified";
                      }

                      $statement = $this->pdo->prepare(self::EDIT_PRODUCT_SPEC);
                      $statement->execute(array($value, $specId));

                  }
              }
            }
            

            $this->pdo->commit();

            return $productId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    function getProductByID($productId)
    {
        $statement = $this->pdo->prepare(self::GET_PRODUCT_BY_ID);
        $statement->execute(array($productId));
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        return $product;
    }

    function getProductByIDAdmin($productId)
    {
        $statement = $this->pdo->prepare(self::GET_PRODUCT_BY_ID_ADMIN);
        $statement->execute(array($productId));
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        return $product;
    }

    function getSubCatProducts($subcatId, $offset, $filter, $minPrice, $maxPrice)
    {
        switch ($filter) {
            case 1:
                $statement = $this->pdo->prepare(self::GET_SUBCAT_PRODUCTS_NEWEST);
                break;
            case 2:
                $statement = $this->pdo->prepare(self::GET_SUBCAT_PRODUCTS_MOST_SOLD);
                break;
            case 3:
                $statement = $this->pdo->prepare(self::GET_SUBCAT_PRODUCTS_HIGHEST_RATED);
                break;
        }

        $statement->bindValue(':sub', (int)$subcatId, PDO::PARAM_INT);
        $statement->bindValue(':off', (int)$offset, PDO::PARAM_INT);
        $statement->bindValue(':minP', (int)$minPrice, PDO::PARAM_INT);
        $statement->bindValue(':maxP', (int)$maxPrice, PDO::PARAM_INT);

        $statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    function getProductPrice($productId)
    {
        $statement = $this->pdo->prepare(self::GET_PRODUCT_BY_ID);
        $statement->execute(array($productId));
        $product = $statement->fetch();

        return $product['price'];
    }


    function getTopRated()
    {

        $statement = $this->pdo->prepare(self::GET_MOST_RATED_PRODUCTS);
        $statement->execute(array());
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }


    function getRelated($subCat, $product)
    {

        $statement = $this->pdo->prepare(self::GET_RELATED_PRODUCTS);
        $statement->execute(array($product, $subCat));
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }


    function getMostRecent()
    {

        $statement = $this->pdo->prepare(self::GET_MOST_RECENT_PRODUCTS);
        $statement->execute(array());
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    function searchProduct($needle)
    {

        $statement = $this->pdo->prepare(self::SEARCH_PRODUCTS);
        $statement->execute(array("%$needle%"));

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    function searchProductNoLimit($needle)
    {

        $statement = $this->pdo->prepare(self::SEARCH_PRODUCTS_NO_LIMIT);
        $statement->execute(array("%$needle%"));

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function mostSoldProducts()
    {

        $statement = $this->pdo->prepare(self::GET_MOST_SOLD);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

 
    function getAllProductsAdmin()
    {
        $statement = $this->pdo->prepare(self::GET_ALL_PRODUCTS_ADMIN);
        $statement->execute();

        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    function getAllProductsGuest()
    {
        $statement = $this->pdo->prepare(self::GET_ALL_PRODUCTS_GUEST);
        $statement->execute(array());
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }


    function toggleVisibility($productId, $toggleTo)
    {
        $statement = $this->pdo->prepare(self::TOGGLE_VISIBILITY);
        $statement->execute(array($toggleTo, $productId));

        return true;
    }
}
