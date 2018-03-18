<?php
session_start();

/* Database Config */
include 'db/db-config.php';

/* Users Function */
include 'func/user-functions.php';
$userfunc = new UserFunc($dbh);

?>
