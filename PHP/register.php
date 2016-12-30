<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head><meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" /> <title>Registration</title></head>
  <body>
    <?php

    $page_title = 'Register';
    include ('../Pages/Header.html');
    if (isset($_COOKIE['user_id']))
    {
      require ('login_functions.inc.php');
      redirect_user();
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {

      require ('../../../mysqli_connect.php');

      $errors = array();

      if (empty($_POST['first_name']))
      {
        $errors[] = 'You forgot to enter your first name.';
      }
      else
      {
        $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
      }

      if (empty($_POST['last_name']))
      {
        $errors[] = 'You forgot to enter your last name.';
      }
      else
      {
        $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
      }

      if (empty($_POST['email']))
      {
        $errors[] = 'You forgot to enter your email.';
      }
      else
      {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));

        $q = "SELECT user_id, first_name
        FROM Users WHERE email='$e'";

        $r = @mysqli_query ($dbc, $q);

        if (mysqli_num_rows($r)> 0)
        {
          $errors[] = 'Sorry the given email address is already in use.';
        }
      }

      if (!empty($_POST['pass1']))
      {
        if ($_POST['pass1'] != $_POST['pass2'])
        {
          $errors[] = 'Your password did not match the confirmed password.';
        }
        else
        {
          $p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
        }
      }
      else
      {
        $errors[] = 'You forgot to enter your password.';
      }
      if (empty($errors))
      {

        $q = "INSERT INTO Users (first_name, last_name, email, pass, reg_date) VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW() )";

        $r = @mysqli_query ($dbc, $q);

        if ($r)
        {

          echo '<div class="HeaderMessage"><h1>Thank you!</h1>

          <p>You are now registered.</p><p>
          <br /></p></div>';
          header("Refresh:3;URL=../Pages/HomePage.php");

        }
        else
        {

          echo '<div class="HeaderMessage"><h1>System Error</h1>

          <p class="error">You could not be registered due to a system error. We apologize for
          any inconvenience.</p>';

          echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p></div>';

        }

        mysqli_close($dbc);

        include ('../Pages/Footer.html');

        exit( );
      }
      else
      {
        echo '<div class="HeaderMessage"><h1>Error!</h1>

        <p class="error">The following error(s) occurred:<br />';

        foreach ($errors as $msg)
        {
            echo " - $msg<br />\n";
        }
        echo '</p><p>Please try again.</p><p><br /></p></div>';

      }
      mysqli_close($dbc);
    }
    ?>
    <main id="pageContainer">
    <div class="BasicForm">
      <p class="LargeBoldTitle">Register</p>

      <form action="register.php" method="post">

      <p><label>First Name: </label><input type="text" name="first_name" size="20" maxlength="20" value="<?php if
      (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>

      <p><label>Last Name: </label><input type="text" name="last_name" size="20" maxlength="40" value="<?php if
      (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>

      <p><label>Email Address: </label><input type="text" name="email" size="20" maxlength="60" value="<?php if
      (isset($_POST['email'])) echo $_POST['email']; ?>" /> </p>

      <p><label>Password: </label><input type="password" name="pass1" size="20" maxlength="20" value="<?php if
      (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" /></p>

      <p><label>Confirm Password: </label><input type="password" name="pass2" size="20" maxlength="20"
        value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" /></p>

        <p class="BasicCenter"><input class="BigButton" type="submit" name="submit" value="Register" /></p>

      </form>
    </div>
    <p>Already have an account?</p>
    <p><a href="login.php">Login</a></p>
  </main>

      <?php include ('../Pages/Footer.html'); ?>

  </body>
</html>
