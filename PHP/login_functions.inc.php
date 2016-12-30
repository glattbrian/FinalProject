<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head><meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" /> <title>Login</title></head>
  <body>

    <?php
    function redirect_user ($page = '../Pages/HomePage.php')
    {
      $url = 'http://localhost:8888' . $_SERVER['HTTP_ HOST'] . dirname($_SERVER['PHP_SELF']);
      $url = rtrim($url, '/\\');
      $url .= '/' . $page;
      header("Location: $url");
      exit();
    }

    function check_login($dbc, $email = '', $pass = '')
    {
      $errors = array();

      if (empty($email))
      {
        $errors[] = 'You forgot to enter
        your email address.';
      }
      else
      {
        $e = mysqli_real_escape_string($dbc, trim($email));
      }

      if (empty($pass))
      {
        $errors[] = 'You forgot to enter
        your password.';
      }
      else
      {
        $p = mysqli_real_escape_string($dbc, trim($pass));
        $p=SHA1($p);
      }
      if (empty($errors))
      {
        $q = "SELECT user_id, first_name
        FROM Users WHERE email='$e' AND
        pass='$p'";

        $r = @mysqli_query ($dbc, $q);

        if (mysqli_num_rows($r) == 1)
        {

          $row = mysqli_fetch_array ($r,
          MYSQLI_ASSOC);

          return array(true, $row);

        }
        else
        {
          $errors[] = 'The email address
          and password entered do not match those on file.';
        }
      }
      return array(false, $errors);
    }
    ?>
  </body>
</html>
