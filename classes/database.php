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
        $db_host = $this->config['DB_HOST'];
        $db_database = $this->config['DB_DATABASE'];
        $db_username = $this->config['DB_USERNAME'];
        $db_password = $this->config['DB_PASSWORD'];
        $this->connection = pg_connect("host=$db_host dbname=$db_database user=$db_username password=$db_password");
        $this->report_error();
    }

    /**
     * Display error to user
     */
    public function report_error() {
        if ($this->connection && pg_last_error($this->connection)) {
            die(pg_last_error($this->connection));
        } else if (!$this->connection) {
            die("No database connection!");
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
        $result = pg_query($sql);
        $this->report_error();
        $returned_array = array();
        while($item = pg_fetch_array($result, null, PGSQL_ASSOC)) {
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