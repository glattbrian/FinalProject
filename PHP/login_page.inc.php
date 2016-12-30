<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head><meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" /> <title>Login</title></head>
  <body>
    <?php

    $page_title = 'Login';

    include ('../Pages/Header.html');

    if (isset($errors) && !empty($errors))
    {

      echo '<div class="HeaderMessage"><h1>Error!</h1>

      <p class="error">The following
      error(s) occurred:<br />';

      foreach ($errors as $msg)
      {

        echo " - $msg<br />\n";

      }
      echo '</p><p>Please try again.</p></div>';
    }
    ?>
    <main id="pageContainer">
    <div class="BasicForm">
    <h1 class="LargeBoldTitle">Login</h1>

    <form action="login.php" method="post">

      <p><label>Email Address:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label><input type="text"
        name="email" size="20" maxlength="60" /></p>

      <p><label>Password: </label><input type="password"
        name="pass" size="20" maxlength="20" /></p>

      <p class="BasicCenter"><input class="BigButton" type="submit" name="submit"
        value="Login" /></p>

      </form>
    </div>
    <p>Don't have an account?</p>
    <p>Register with us. (<a href="register.php">Register</a>)</p>
  </main>
      <?php include ('../Pages/Footer.html'); ?>
    </body>
  </html>
