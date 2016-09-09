<?php
// define config file path
define('CONFIG_FILEPATH', 'app.env');

/**
 * Class Database
 *
 * Simple implementation for connecting database
 */
class Database {

    private $config;

    public $connection;

    /**
     * Database constructor.
     *
     * Read database config from app.env
     */
    public function Database() {
        $this->connect();
    }

    /**
     * Try to connect database
     */
    public function connect() {
        $this->parse_config_file();
        $this->connection = new mysqli($this->config['DB_HOST'], $this->config['DB_USERNAME'],
                                        $this->config['DB_PASSWORD'], $this->config['DB_DATABASE']);
        $this->report_error();
    }

    /**
     * Display error to user
     */
    public function report_error() {
        if ($this->connection && $this->connection->connect_errno) {
            die($this->connection->connect_errno . "\n" . $this->connection->connect_error);
        }
    }

    /**
     * Try to parse config file
     */
    public function parse_config_file() {
        $this->config = parse_ini_file(CONFIG_FILEPATH);
        if (!isset($this->config['DB_HOST'])) {
            die("DB_HOST required in app.env");
        }
        if (!isset($this->config['DB_DATABASE'])) {
            die("DB_DATABASE required in app.env");
        }
        if (!isset($this->config['DB_USERNAME'])) {
            die("DB_USERNAME required in app.env");
        }
        if (!isset($this->config['DB_PASSWORD'])) {
            die("DB_PASSWORD required in app.env");
        }
    }

    /**
     * Try to execute sql
     *
     * @param $sql
     * @return array
     */
    public function execute($sql) {
        $result = $this->connection->query($sql);
        $this->report_error();
        $returned_array = array();
        while($item = $result->fetch_assoc()) {
            array_push($returned_array, $item);
        }
        return $returned_array;
    }

    /**
     * Execute the sql and return the number of rows
     *
     * @param $sql
     * @return mixed
     */
    public function getNumRows($sql) {
        $result = $this->connection->query($sql);
        $this->report_error();
        return $result->num_rows;
    }

}