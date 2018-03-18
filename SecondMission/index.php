<?php
require 'core/init.php';

//Set the header to not cache (Just to be sure :D).
header('Cache-Control: no-cache, must-revalidate, max-age=0');

//Check if user is logged in to the system.
if(!$userfunc->IsLogged())
{
  //If not show him the authenticate.
  header('HTTP/1.1 401 Authorization Required');
  header('WWW-Authenticate: Basic realm="Access denied"');
  //Checks if the user and password are empty and if they are return;
  if(empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW']))
  {
    return;
  }
  //Check user and password in the database.
  $userfunc->LoginUser($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  return;
}
//Insert random number into database clicked.
if(isset($_POST['submit_text']))
{
  $thetext = $_POST['text_input'];
  $userfunc->InsertText($_SESSION['uid'], $thetext);
  echo 'The text : '. htmlspecialchars($thetext) . ' has been inserted into the DB.';
}

//Logout clicked.
if(isset($_POST['submit_logout']))
{
  //Destroy everything.
  session_destroy();
  if($userfunc->IsLogged())
  {
    $userfunc->LogoutLogin();
    header('Location: index.php');
  }
}
?>
<form action="#" method="post">
  <input type="text" name="text_input"><br>
  <input type="submit" name="submit_text" value="Insert random number into database">
  <input type="submit" name="submit_logout" value="Logout">
</form>
