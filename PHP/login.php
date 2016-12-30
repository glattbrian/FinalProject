<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head><meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" /> <title>Login</title></head>
  <body>

    <?php
    if (isset($_COOKIE['user_id']))
    {
      require ('login_functions.inc.php');
      redirect_user();
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      require ('login_functions.inc.php');

      require ('../../../mysqli_connect.php');

      list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);

      if ($check)
      {

        setcookie ('user_id', $data['user_id'], time()+3600, '/', '', 0, 0);
        setcookie ('first_name', $data['first_name'], time()+3600, '/', '', 0, 0);
        //set administrator

        redirect_user();
      }
      else
      {
        $errors = $data;
      }
      mysqli_close($dbc);
    }
    include ('login_page.inc.php');
    ?>
  </body>
</html>
