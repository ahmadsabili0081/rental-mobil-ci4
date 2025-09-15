<?php
namespace App\Libraries;

class Hash
{
  public static function set_hash($password)
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

  public static function check_password($password, $db_password)
  {
    if (password_verify($password, $db_password)) {
      return true;
    } else {
      return false;
    }
  }
}
?>