<?php
$host = "localhost";    // Nama host
$username = "root";         // Username database
$password = "";   // Password database
$database = "labaho_db";   // Nama database
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}