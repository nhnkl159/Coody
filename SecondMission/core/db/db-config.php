<?php

/* Database information to our login system */

$dsn = 'mysql:dbname=coody;host=localhost';
$user = 'root';
$password = '';
try
{
  $dbh = new PDO($dsn, $user, $password);
}
catch (PDOException $e)
{
  echo 'Connection failed: ' . $e->getMessage();
}

?>
