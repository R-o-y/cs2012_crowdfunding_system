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
	private $name;
	private $email;
	private $pass;
	
	public function User($user_arr) {
        self::checkConnection();
		$this->validateAndSetData(user_arr);
	}
	
    public static function checkConnection() {
        global $gb_connection;
        if ($gb_connection) {
            self::$connection = $gb_connection;
        } else {
            die("No valid db connection");
        }
    }
	
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
		$this->id = $user_arr['id'];
		$this->is_admin = FALSE;
		$this->name = $user_arr['name'];
		$this->email = $user_arr['email'];
		$this->pass = password_hash($user_arr['password'], PASSWORD_DEFAULT);
	}
	
	public function isValidPassword(String $user_input) {
		return password_verify($user_input, $pass);
	}
	
}