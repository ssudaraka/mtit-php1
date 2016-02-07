<?php

session_start();

$hostname = "localhost";
$username = "root";
$password = "root";
$database = "mtitphp";

$connection = new mysqli($hostname, $username, $password, $database);

if ($connection->connect_errno) {
    die("Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $connection->connect_error);
}