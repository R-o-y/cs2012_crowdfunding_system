<?php

/**
 * Record the category table in database
 *
 * Class Category
 */
Class Category {

    public $id;
    public $name;
    public $activate;

    private static $connection;

    /**
     * Create category from array
     *
     * Category constructor.
     * @param $category_arr
     */
    public function Category($category_arr) {
        $this->validateAndSetData($category_arr);
        $this->checkIfCurrent();
    }

    /**
     * Validate data and set to instance
     *
     * @param $category_arr
     */
    public function validateAndSetData($category_arr) {
        if (!isset($category_arr['id'])) {
            die('id field is required');
        }
        if (!isset($category_arr['name'])) {
            die('name field is required');
        }
        $this->id = $category_arr['id'];
        $this->name = $category_arr['name'];
    }

    /**
     * Check $_GET['_category'] to see if the current category is activated
     *
     */
    public function checkIfCurrent() {
        if (isset($_GET['_category']) && $_GET['_category'] == $this->id) {
            $this->activate = true;
        } else {
            $this->activate = false;
        }
    }


    /**
     * Check global connection
     */
    public static function checkConnection() {
        global $gb_connection;
        if ($gb_connection) {
            self::$connection = $gb_connection;
        } else {
            die("No valid db connection");
        }
    }

    /**
     * Get all categories in database
     *
     * @return array
     */
    public static function getAll() {
        self::checkConnection();
        $results = self::$connection->execute("SELECT * FROM category;");
        $categories = array();
        foreach ($results as $category_arr) {
            array_push($categories, new Category($category_arr));
        }
        return $categories;
    }

}