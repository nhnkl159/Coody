<?php


class UserFunc
{
  public $db;
  function __construct($dbh)
  {
      $this->db = $dbh;
  }

  public function IsLogged()
  {
    if(isset($_SESSION['user']) &&  isset($_SESSION['uid']))
    {
      return true;
    }
    return false;
  }

  public function LogoutLogin()
  {
    if($this->IsLogged())
    {
      unset($_SESSION['uid']);
      unset($_SESSION['user']);
    }
  }

  public function LoginUser($user, $pass)
  {
    $SQLLoginCheck = $this->db->prepare('SELECT COUNT(*) FROM `users` WHERE `username` = ?');
    $SQLLoginCheck->bindParam(1 , $user);
    $SQLLoginCheck->execute();
    $countlogin = $SQLLoginCheck->fetchColumn(0);
    if($countlogin == 0)
    {
      return false;
    }
    else if($countlogin == 1)
    {
      $SQLCheck = $this->db->prepare('SELECT * FROM `users` WHERE `username` = ?');
      $SQLCheck->bindParam(1 , $user);
      $SQLCheck->execute();
      $row = $SQLCheck->fetch();

      if(password_verify($pass, $row['password']))
      {
        $_SESSION['uid'] = $row['id'];
        $_SESSION['user'] = $user;
        return true;
      }
    }
    return false;
  }

  public function InsertRandomNum($userid)
  {
    $random = rand(1, 9999);
    $SQLCheck = $this->db->prepare('INSERT INTO `data`(userid, randomnum) VALUES(?, ?)');
    $SQLCheck->bindParam(1 , $userid);
    $SQLCheck->bindParam(2 , $random);
    $SQLCheck->execute();
  }
}
?>
