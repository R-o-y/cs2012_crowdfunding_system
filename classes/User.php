<?php


/**
 * Class User
 *
 * Model for all users
 */
class User {
	private static $connection;
	
	public $id;
	public $is_admin;
    public $name;
    public $email;
    public $pass;

    /**
     * User constructor.
     * @param $user_arr
     */
	public function User($user_arr) {
        self::checkConnection();
		$this->validateAndSetData($user_arr);
	}

    /**
     * Verify database connection
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
     * Verify data
     *
     * @param $user_arr
     */
	private function validateAndSetData($user_arr) {
		if(!isset($user_arr['id'])) {
			die("User id required");
		}
		if(!isset($user_arr['name'])) {
			die("Name required");
		}
		if(!isset($user_arr['email'])) {
			die("Email address required");
		}
		if(!isset($user_arr['password'])) {
			die("Password required");
		}
        if(!isset($user_arr['is_admin'])) {
            die("isAdmin required");
        }
		$this->id = $user_arr['id'];
		$this->is_admin = $user_arr['is_admin'] == "f" ? false : true;
		$this->name = $user_arr['name'];
		$this->email = $user_arr['email'];
		$this->pass = $user_arr['password'];
	}

    /**
     * Get user by id
     *
     * @param $id
     * @return null|User
     */
    public static function getUserById($id) {
        self::checkConnection();
        settype($id, 'integer');
        $sql = sprintf("SELECT * FROM account WHERE id = %d;", $id);
        $results = self::$connection->execute($sql);
        if (count($results) >= 1) {
            return new User($results[0]);
        } else {
            return null;
        }
    }
    public static function getUserByEmail($email) {
        self::checkConnection();
        $sql = sprintf("SELECT * FROM account WHERE email = '%s';", $email);
        $results = self::$connection->execute($sql);
        if (count($results) >= 1) {
            return new User($results[0]);
        } else {
            return null;
        }
    }   
	public static function checkValidity($email, $password) {
        self::checkConnection();
        $sql = sprintf("SELECT * FROM account WHERE email = '%s' AND password = '%s';", $email, $password);
        $results = self::$connection->execute($sql);
        if (count($results) == 1) {
            return new User($results[0]);
        } else {
            return null;
        }
    }
    public function getName() {
        return $this->name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setPass($pass) {
        $this->pass = $pass;
        $sql = sprintf("UPDATE account SET password = '%s' WHERE id = %d;", $this->pass, $this->id);
        $results = self::$connection->execute($sql);
        return true;
    }
    public static function getCurrentUser() {
        if (isset($_SESSION['email'])) {
            $user = self::getUserByEmail($_SESSION['email']);
            return $user;
        } else {
            return null;
        }
    }
}