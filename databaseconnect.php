<?php
function dbConn()
{
$host = 'localhost';
$db_test   = 'blogdb';
$username = 'root';
$password = 'root';
$charset = 'utf8';
$dsn = "mysql:host=" . $host . ";dbname=" . $db_test  . ";charset=" . $charset;
$options =
    [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
return new PDO($dsn, $username, $password, $options);
}
?>