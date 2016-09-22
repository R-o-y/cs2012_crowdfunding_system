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
    public function Category($category_arr = null) {
        if ($category_arr!=null) {
            self::checkConnection();
            $this->validateAndSetData($category_arr);
            $this->checkIfCurrent();
        }
    }

    /**
     * Delete a category, due to the constraint in database
     * project category relationships will also be deleted
     */
    public function delete() {
        $sql = sprintf("DELETE FROM category WHERE id=%d", $this->id);
        self::$connection->execute($sql);
    }


    /**
     * save field in database
     *
     */
    public function save() {
        if (self::getCategoryById($this->id) == null) {
            // should create
            $sql = "INSERT INTO category (name) VALUES ('%s') RETURNING id;";
            $auth_user = User::getUserById(1);
            $sql = sprintf($sql, pg_escape_string($this->name));
            $results = self::$connection->execute($sql);
            $this->id = $results[0]["id"];
        } else {
            // should update
            $sql = "UPDATE category SET name='%s' WHERE id=%d";
            $sql = sprintf($sql, pg_escape_string($this->name), addslashes($this->id));
            self::$connection->execute($sql);
        }
    }

    /**
     * Update the object with array
     *
     * @param $arr
     */
    public function update($arr) {
        // update attribute
        foreach ($arr as $key => $value) {
            $this->{$key} = $value;
        }
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
     * Set a project so that it belongs to the category
     *
     * @param $project_id
     */
    public function setProject($project_id) {
        settype($project_id, 'integer');
        $sql = sprintf("INSERT INTO project_category (project_id, category_id) VALUES (%d, %d)", $project_id, $this->id);
        self::$connection->execute($sql);
    }

    /**
     * Get a specific category by id
     */
    public static function getCategoryById($id) {
        self::checkConnection();
        settype($id, 'integer');
        $sql = sprintf("SELECT * FROM category WHERE id = %d", $id);
        $results = self::$connection->execute($sql);
        if (count($results) >= 1) {
            return new Category($results[0]);
        } else {
            return null;
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

    /**
     * Check delete request
     */
    public static function checkDeleteRequest() {
        if (isset($_GET['category_id'])) {
            $category = Category::getCategoryById($_GET['category_id']);
            if ($category) {
                $category->delete();
            }
        }
        redirect(url(['_page' => 'home']));
    }

    /**
     * Check update request
     */
    public static function checkUpdateRequest() {
        self::checkConnection();
        $data = self::validateUpdateRequest();
        if ($data != null) {
            $category = self::getCategoryById($data['id']);
            $category->update($data);
            $category->save();
            redirect(url(['_page' => 'home', '_category' => $category->id]));
        }
    }

    /**
     * Check create request
     */
    public static function checkCreateRequest() {
        self::checkConnection();
        $data = self::validateCreateRequest();
        $category = new Category();
        if ($data != null) {
            $category->update($data);
            $category->save();
            redirect(url(['_page' => 'home', '_category' => $category->id]));
        }
    }

    /**
     * Validate category update parameters
     *
     * @return array|null
     */
    public static function validateUpdateRequest() {
        $errors = array();
        $data = array();
        self::checkID($errors, $data);
        self::checkName($errors, $data);
        if (count($errors) > 0 && count($data) > 0) {
            redirect(url(['_page' => 'home']));
        } else if (count($errors) == 0){
            return $data;
        }
        return null;
    }

    /**
     * Validate category create parameters
     *
     * @return array|null
     */
    public static function validateCreateRequest() {
        $errors = array();
        $data = array();
        self::checkName($errors, $data);
        if (count($errors) > 0 && count($data) > 0) {
            redirect(url(['_page' => 'home']));
        } else if (count($errors) == 0){
            return $data;
        }
        return null;
    }

    private static function checkID(&$errors, &$data) {
        if (isset($_POST['category_id']) && $_POST['category_id'] != "") {
            $data['id'] = $_POST['category_id'];
        } else {
            $errors['category_id'] = 'Cannot identify category id';
        }
    }
    private static function checkName(&$errors, &$data) {
        if (isset($_POST['category_name']) && $_POST['category_name'] != "") {
            $data['name'] = $_POST['category_name'];
        } else {
            $errors['category_name'] = 'Name required';
        }
    }


}