<?php
require 'config/constants.php';

//connect to the database

$connection = new mysqli(DB_HOST,DB_USER, DB_PASS, DB_NAME);

if ($connection->connect_errno) {
    die('Database connection failed: ' . $connection->connect_error);
}