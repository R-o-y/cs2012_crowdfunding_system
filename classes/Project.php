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
    public function Project($project_arr=null) {
        if ($project_arr!=null) {
            $this->validateAndSetData($project_arr);
        }
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
     * Get bootstrap class
     *
     * @return string
     */
    public function getDisplayClass() {
        $days_left_num = $this->getRemainingDay();
        $summary_class = 'info';
        if ($this->getRaisedAmount() >= $this->goal) {
            $summary_class = 'success';
        } else if ($days_left_num < 0) {
            $summary_class = 'danger';
        } else if ($days_left_num < 10) {
            $summary_class = 'warning';
        }
        return $summary_class;
    }

    /**
     * Get end day
     */
    public function getEndDay() {
        $end_date = clone $this->start_date;
        $end_date->add(new DateInterval('P' . $this->duration . 'D'));
        return $end_date;
    }

    /**
     * Get remaining day to go
     */
    public function getRemainingDay() {
        $days_left = date_diff(new DateTime(), $this->getEndDay(), $absolute = false);
        $days_left_num = (int)$days_left->format('%r%a');
        return $days_left_num;
    }

    /**
     * Get total raised amount
     *
     * @return mixed
     */
    public function getRaisedAmount() {
        $sql = sprintf("SELECT SUM(amount) AS total_amount FROM donation WHERE project_id = %d;", $this->id);
        $results = self::$connection->execute($sql);
        $total_amount = $results[0]["total_amount"];
        return $total_amount ? $total_amount : 0;
    }

    /**
     * Get image url from the description
     */
    public function getDescriptionImages() {
        preg_match( '@src="([^"]+)"@' , $this->description, $match);
        return $match;
    }

    /**
     * Get description of project without image
     *
     * @return mixed
     */
    public function getDescriptionSummary() {
        return truncateText(plaintext($this->description), 300);
    }

    /**
     * save field in database
     *
     */
    public function save() {
        if (self::getProjectById($this->id) == null) {
            // should create
            $sql = "INSERT INTO project (title, description, goal, start_date, duration, owner_id) VALUES ('%s', '%s', %d, '%s', %d, %d) RETURNING id;";
            $auth_user = User::getCurrentUser();
            $sql = sprintf($sql, addslashes($this->title), pg_escape_string($this->description), $this->goal, $this->start_date->format('Y-m-d'), $this->duration, $auth_user->id);
            $results = self::$connection->execute($sql);
            $this->id = $results[0]["id"];
        } else {
            // should update
            $sql = "UPDATE project SET title='%s', description='%s', goal=%d, start_date='%s', duration=%d, owner_id=%d WHERE id=%d";
            $auth_user = User::getUserById(1);
            $sql = sprintf($sql, addslashes($this->title), pg_escape_string($this->description), $this->goal, $this->start_date->format('Y-m-d'), $this->duration, $auth_user->id, $this->id);
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
     * Delete a project, due to the constraint in database
     * project category relationships and donations will also be deleted
     */
    public function delete() {
        $sql = sprintf("DELETE FROM project WHERE id=%d", $this->id);
        self::$connection->execute($sql);
    }

    /**
     * Update category
     *
     * @param $categories
     */
    public function updateCategory($categories) {
        // update category
        $this->clearCategories();
        foreach ($categories as $category_id) {
            $category = Category::getCategoryById($category_id);
            if ($category) {
                $category->setProject($this->id);
            }
        }
        $arr['categories'] = null;
    }

    /**
     * Clear all category relationship in current project
     */
    private function clearCategories() {
        $sql = "DELETE FROM project_category WHERE project_id = %d";
        $sql = sprintf($sql, $this->id);
        self::$connection->execute($sql);
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
        $sql = "SELECT p.*, (p.start_date+p.duration) AS end_date, (p.goal - COALESCE(SUM(d.amount), 0)) AS rem FROM project p LEFT JOIN donation d ON d.project_id = p.id GROUP BY p.id ORDER BY end_date DESC, rem DESC;"; //coalesce similar with isnull;
        if(isset($_GET['_category'])) {
            $category_id = $_GET['_category'];
            settype($category_id, 'integer');
            $sql = sprintf("SELECT p.*,(p.start_date+p.duration) AS end_date, (p.goal - COALESCE(SUM(d.amount), 0)) AS rem FROM project p LEFT JOIN donation d ON d.project_id = p.id WHERE p.id IN (SELECT c.project_id FROM project_category c WHERE c.category_id = %d) GROUP BY p.id ORDER BY end_date DESC, rem DESC;", $category_id);
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

    /**
     * Check whether the request is to create project
     */
    public static function checkCreateRequest() {
        self::checkConnection();
        $data = self::validateCreateRequest();
        $project = new Project();
        if ($data != null) {
            $project->update($data);
            $project->save();
            $project->updateCategory($data['categories']);
            redirect(url(['_page' => 'project_detail', 'project_id' => $project->id]));
        }
    }

    /**
     * Validate create request data
     *
     * @return array|null
     */
    public static function validateCreateRequest() {
        $errors = array();
        $data = array();
        self::checkTitle($errors, $data);
        self::checkDescription($errors, $data);
        self::checkGoal($errors, $data);
        self::checkStartDate($errors, $data);
        self::checkDuration($errors, $data);
        self::checkCategories($errors, $data);
        if (count($errors) > 0 && count($data) > 0) {
            redirect(url(['_page' => 'create_project']));
        } else if (count($errors) == 0){
            return $data;
        }
        return null;
    }

    /**
     * Check whether the request is to update
     */
    public static function checkUpdateRequest() {
        self::checkConnection();
        $data = self::validateUpdateRequest();
        if ($data != null) {
            $project = self::getProjectById($data['id']);
            $project->update($data);
            $project->save();
            $project->updateCategory($data['categories']);
            redirect(url(['_page' => 'project_detail', 'project_id' => $data['id']]));
        }
    }

    /**
     * Validate post data
     */
    private static function validateUpdateRequest() {
        $errors = array();
        $data = array();
        self::checkID($errors, $data);
        self::checkTitle($errors, $data);
        self::checkDescription($errors, $data);
        self::checkGoal($errors, $data);
        self::checkStartDate($errors, $data);
        self::checkDuration($errors, $data);
        self::checkCategories($errors, $data);
        if (count($errors) > 0 && count($data) > 0) {
            redirect(url(['_page' => 'home']));
        } else if (count($errors) == 0){
            return $data;
        }
        return null;
    }
    private static function checkID(&$errors, &$data) {
        if (isset($_POST['project_id']) && $_POST['project_id'] != "") {
            $data['id'] = $_POST['project_id'];
        } else {
            $errors['project_id'] = 'Cannot identify project id';
        }
    }
    private static function checkTitle(&$errors, &$data) {
        if (isset($_POST['project_title']) && $_POST['project_title'] != "") {
            $data['title'] = $_POST['project_title'];
        } else {
            $errors['project_title'] = 'Title required';
        }
    }
    private static function checkDescription(&$errors, &$data) {
        if (isset($_POST['project_description']) && $_POST['project_description'] != "") {
            $data['description'] = $_POST['project_description'];
        } else {
            $errors['project_description'] = 'Description required';
        }
    }
    private static function checkGoal(&$errors, &$data) {
        if (isset($_POST['project_goal']) && $_POST['project_goal'] != "") {
            $data['goal'] = $_POST['project_goal'];
        } else {
            $errors['project_goal'] = 'Goal required';
        }
    }
    private static function checkStartDate(&$errors, &$data) {
        if (isset($_POST['project_start_date']) && $_POST['project_start_date'] != "") {
            $data['start_date'] = DateTime::createFromFormat('d/m/Y', $_POST['project_start_date']);
        } else {
            $errors['project_start_date'] = 'Start date required';
        }
    }
    private static function checkDuration(&$errors, &$data) {
        if (isset($_POST['project_duration']) && $_POST['project_duration'] != "") {
            $data['duration'] = $_POST['project_duration'];
        } else {
            $errors['project_duration'] = 'Duration required';
        }
    }
    private static function checkCategories(&$errors, &$data) {
        if (isset($_POST['project_categories'])) {
            $categories = [];
            foreach ($_POST['project_categories'] as $project_category) {
                array_push($categories, $project_category);
            }
            $data['categories'] = $categories;
        }
    }


}