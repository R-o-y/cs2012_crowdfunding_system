<?php
date_default_timezone_set("Asia/Singapore");
require('classes/Database.php');
require('classes/Project.php');
$gb_connection = new Database();

// simple router
$page = isset($_GET['_page']) ? isset($_GET['_page']) : 'home';

if (file_exists('pages/' . $page)) {
    require('pages/' . $page . '.php');
} else {
    require('pages/home.php');
}