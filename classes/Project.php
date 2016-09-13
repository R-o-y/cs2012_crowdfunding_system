<?php

/**
 * Class Project
 *
 * Model for all project
 */
class Project {
    private static $connection;

    public $id;
    public $title;
    public $description;
    public $goal;
    public $start_date;
    public $duration;
    public $owner_id;

    /**
     * Project constructor.
     *
     * @param null $db_connection
     */
    public function Project($project_arr) {
        $this->validateAndSetData($project_arr);
    }

    public function validateAndSetData($project_arr) {
        if (!isset($project_arr['id'])) {
            die("id filed required");
        }
        if (!isset($project_arr['title'])) {
            die("title filed required");
        }
        if (!isset($project_arr['description'])) {
            die("description filed required");
        }
        if (!isset($project_arr['goal'])) {
            die("goal filed required");
        }
        if (!isset($project_arr['start_date'])) {
            die("start_date filed required");
        }
        if (!isset($project_arr['duration'])) {
            die("duration filed required");
        }
        if (!isset($project_arr['owner_id'])) {
            die("owner_id filed required");
        }
        $this->id = $project_arr['id'];
        $this->title = $project_arr['title'];
        $this->description = $project_arr['description'];
        $this->goal = $project_arr['goal'];
        $this->start_date = new DateTime($project_arr['start_date']);
        $this->duration = $project_arr['duration'];
        $this->owner_id = $project_arr['owner_id'];
    }

    /**
     * Get the project blonging categories
     *
     */
    public function getCategories() {
        $sql = sprintf("SELECT * FROM category c WHERE EXISTS (SELECT * FROM project_category pc WHERE pc.project_id = %d AND pc.category_id = c.id)", $this->id);
        $categories = array();
        $results = self::$connection->execute($sql);
        foreach ($results as $category_arr) {
            array_push($categories, new Category($category_arr));
        }
        return $categories;
    }

    /**
     * Get owner of this project
     */
    public function getOwner() {
        // no need to check whether exist because of database constrain
        return User::getUserById($this->owner_id);
    }

    /**
     * Get number of donators
     *
     * @return mixed
     */
    public function getNumOfDonation() {
        $sql = sprintf("SELECT COUNT(*) AS num_donator FROM donation WHERE project_id = %d;", $this->id);
        $results = self::$connection->execute($sql);
        return $results[0]["num_donator"];
    }


    /**
     * Get number of distict donator
     *
     * @return mixed
     */
    public function getNumOfDonator() {
        $sql = sprintf("SELECT COUNT(DISTINCT user_id) AS num_donator FROM donation WHERE project_id = %d;", $this->id);
        $results = self::$connection->execute($sql);
        return $results[0]["num_donator"];
    }

    /**
     * Get all donations of the project
     *
     * @return array
     */
    public function getDonations() {
        $sql = sprintf("SELECT * FROM donation WHERE project_id = %d;", $this->id);
        $donations = array();
        $results = self::$connection->execute($sql);
        foreach ($results as $donation_arr) {
            array_push($donations, new Donation($donation_arr));
        }
        return $donations;
    }

    /**
     * Get highlight donations
     *
     * @return array
     */
    public function getHighlightDonations() {
        $sql = sprintf("SELECT * FROM donation WHERE project_id = %d ORDER BY amount DESC LIMIT 5;", $this->id);
        $donations = array();
        $results = self::$connection->execute($sql);
        foreach ($results as $donation_arr) {
            array_push($donations, new Donation($donation_arr));
        }
        return $donations;
    }

    /**
     * Get total raised amount
     *
     * @return mixed
     */
    public function getRaisedAmount() {
        $sql = sprintf("SELECT SUM(amount) AS total_amount FROM donation WHERE project_id = %d;", $this->id);
        $results = self::$connection->execute($sql);
        return $results[0]["total_amount"];
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
     * Get all data from the database
     *
     * @return array
     */
    public static function getAll() {
        self::checkConnection();
        $sql = "SELECT * FROM project;";
        if(isset($_GET['_category'])) {
            $category_id = $_GET['_category'];
            settype($category_id, 'integer');
            $sql = sprintf("SELECT * FROM project WHERE id IN (SELECT project_id FROM project_category WHERE category_id = %d)", $category_id);
        }
        $results = self::$connection->execute($sql);
        $projects = array();
        foreach ($results as $project_arr) {
            array_push($projects, new Project($project_arr));
        }
        return $projects;
    }

    /**
     * Get a specific project by id
     */
    public static function getProjectById($id) {
        self::checkConnection();
        settype($id, 'integer');
        $sql = sprintf("SELECT * FROM project WHERE id = %d", $id);
        $results = self::$connection->execute($sql);
        if (count($results) >= 1) {
            return new Project($results[0]);
        } else {
            return null;
        }
    }

}