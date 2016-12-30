<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head><meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" /> <title>Logout</title></head>
  <body>
    <?php
    if (!isset($_COOKIE['user_id']))
    {
      require ('login_functions.inc.php');
      redirect_user( );
    }
    else
    {

      setcookie ('user_id', '', time()-3600, '/', '', 0, 0);
      setcookie ('first_name', '', time()-3600, '/', '', 0, 0);
      //set administrator
      $page_title = 'Logged Out!';
      include ('../Pages/Header.html');

      echo "<div class='HeaderMessage'><h1>Logged Out!</h1>
      <p>You are now logged out, {$_COOKIE ['first_name']}!</p></div>";
      header("Refresh:3;URL=../Pages/HomePage.php");
      include ('../Pages/Footer.html');
    }
    ?>
  </body>
</html>
