#### Assignment 1 


#### Connecting  mysql database using php 

```
<?php

/ file connects to your MySQL database. */

// Connection constants
define('DB_HOST',     'localhost');
define('DB_USER',     'rveeravalli');
define('DB_PASSWORD', 'teo7Pup0');
define('DB_DATABASE', 'rveeravalli');
define('DB_PORT',     3306);

// Error-checking to ensure you have set the values above before trying to run one of the examples
if(DB_USER     === 'REPLACEME' ||
DB_PASSWORD === 'REPLACEME' ||
DB_DATABASE === 'REPLACEME')
{
die("You must set your database connection variables in db_connect.php before viewing this example!");
}

// Connect to the database using PHP's MySQLi object-oriented library
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
if ($mysqli->connect_errno)
{
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}
echo "Database has been connected";

?>
