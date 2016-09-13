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

    private static $currentCategory;
    private static $connection;

    /**
     * Create category from array
     *
     * Category constructor.
     * @param $category_arr
     */
    public function Category($category_arr) {
        self::checkConnection();
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
     * Get number of projects that belong to the category
     *
     * @return number
     */
    public function getBelongedNumProjects() {
        $sql = "SELECT numPorject FROM category_numproject WHERE category_id = %d";
        $sql = sprintf($sql, $this->id);
        $results = self::$connection->execute($sql);
        if (count($results) != 1) {
            return 0;
        } else {
            return $results[0]['numporject'];
        }
    }

    /**
     * Get projects under this category
     *
     * @return array
     */
    public function getBelongedProjects() {
        $sql = "SELECT * FROM project p WHERE p.id IN (SELECT pc.project_id FROM project_category WHERE category_id = %d);";
        $sql = sprintf($sql, $this->id);
        $results = self::$connection->execute($sql);
        $projects = array();
        foreach ($results as $project_arr) {
            array_push($projects, new Project($project_arr));
        }
        return $projects;
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

    /**
     * Return current category
     *
     * @return mixed
     */
    public static function current() {
        self::checkConnection();
        if(isset($_GET['_category'])) {
            $category_id = $_GET['_category'];
            settype($category_id, 'integer');
            $sql = sprintf("SELECT * FROM category WHERE id = %d", $category_id);
            $results = self::$connection->execute($sql);
            if (count($results) != 0) {
                return new Category($results[0]);
            } else {
                return null;
            }
        }
        return null;
    }

}