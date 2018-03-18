<?php
require 'core/init.php';
header('Cache-Control: no-cache, must-revalidate, max-age=0');

if(!$userfunc->IsLogged())
{
  header('HTTP/1.1 401 Authorization Required');
  header('WWW-Authenticate: Basic realm="Access denied"');
  if(empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW']))
  {
    return;
  }
  $userfunc->LoginUser($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  return;
}

if(isset($_POST['submit_num']))
{
  $userfunc->InsertRandomNum($_SESSION['uid']);
  echo 'New random number inserted into the DB.';
}
if(isset($_POST['submit_logout']))
{
  session_destroy();
  if($userfunc->IsLogged())
  {
    $userfunc->LogoutLogin();
    header('Location: index.php');
  }
}
?>
<form action="#" method="post">
  <input type="submit" name="submit_num" value="Insert random number into database">
  <input type="submit" name="submit_logout" value="Logout">
</form>
