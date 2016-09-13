<?php


/**
 * Class User
 *
 * Model for all users
 */
class Donation {
    private static $connection;

    public $id;
    public $user_id;
    public $project_id;
    public $message;
    public $amount;
    public $created;

    /**
     * Donation constructor.
     * @param $donation_arr
     */
    public function Donation($donation_arr) {
        self::checkConnection();
        $this->validateAndSetData($donation_arr);
    }

    /**
     * Get the owner of the donation
     */
    public function getOnwer() {
        // no need to check whether exist because of database constrain
        return User::getUserById($this->user_id);
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
     * Validate data
     *
     * @param $donation_arr
     */
    private function validateAndSetData($donation_arr) {
        if(!isset($donation_arr['id'])) {
            die("ID required");
        }
        if(!isset($donation_arr['user_id'])) {
            die("User id required");
        }
        if(!isset($donation_arr['project_id'])) {
            die("Project id address required");
        }
        if(!isset($donation_arr['message'])) {
            die("message required");
        }
        if(!isset($donation_arr['amount'])) {
            die("amount required");
        }
        if(!isset($donation_arr['created'])) {
            die("created required");
        }
        $this->id = $donation_arr['id'];
        $this->user_id = $donation_arr['user_id'];
        $this->project_id = $donation_arr['project_id'];
        $this->message = $donation_arr['message'];
        $this->amount = $donation_arr['amount'];
        $this->created = new DateTime($donation_arr['created']);
    }

}