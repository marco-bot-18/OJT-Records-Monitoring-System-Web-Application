<?php
define('servername', 'localhost');
define('dbUsername', 'root');
define('dbPassword', '');
define('dbName', 'ojtrms_db');

$conn = mysqli_connect(servername, dbUsername, dbPassword, dbName);

if (!$conn) {
	die("connection failed: " . mysqli_connect_error());
}
