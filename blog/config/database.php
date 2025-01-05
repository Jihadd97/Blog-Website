<?php
require 'config/constants.php';

// Connect to the database using the constants
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($connection->connect_errno) {
    die('Database connection failed: ' . $connection->connect_error);
}