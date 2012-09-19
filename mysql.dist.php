<?php
DEFINE('MYSQLI_SERVER', "localhost");
DEFINE('MYSQLI_USER', "root");
DEFINE('MYSQLI_PASSWORD', "");
DEFINE('MYSQLI_DB', "pnck");
$mysqli_connect = mysqli_connect(MYSQLI_SERVER, MYSQLI_USER,MYSQLI_PASSWORD) or die("Could not connect to server");
$mysqli_db = mysqli_select_db($mysqli_connect, MYSQLI_DB) or die("Could not connect to database");
?>