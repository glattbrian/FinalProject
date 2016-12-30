<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head><meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" /> <title>Edit Profile</title></head>
  <body>
    <?php

    $page_title = 'Edit Profile';
    include ('../Pages/Header.html');
    require ('../../../mysqli_connect.php');
    if (!isset($_COOKIE['user_id']))
    {
      require ('login_functions.inc.php');
      redirect_user('../Pages/MustBeLoggedIn.php');
    }
    else
    {
      $id=$_COOKIE['user_id'];
      $q = "SELECT first_name, last_name, email
      FROM Users WHERE user_id='$id'";

      $r = @mysqli_query ($dbc, $q);
      $row = @mysqli_fetch_array ($r, MYSQLI_ASSOC);
      echo $fn;
      $fn=$row['first_name'];
      $ln=$row['last_name'];
      $e=$row['email'];
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $errors = array();

      if (!empty($_POST['first_name']))
      {
        $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
      }

      if (!empty($_POST['last_name']))
      {
        $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
      }

      if (!empty($_POST['email']))
      {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));

        $q = "SELECT user_id, first_name
        FROM Users WHERE email='$e'";

        $r = @mysqli_query ($dbc, $q);
        $row = @mysqli_fetch_array ($r, MYSQLI_NUM);
        $record = $row[0];
        if (mysqli_num_rows($r)> 0&&$id!=$record['user_id'])
        {
          $errors[] = 'Sorry the given email address is already in use.';
        }
      }

      if (empty($errors))
      {
        $q = "UPDATE Users SET first_name='$fn', last_name='$ln', email='$e' WHERE user_id='$id'";

        $r = @mysqli_query ($dbc, $q);

        if ($r)
        {

          echo '<div class="HeaderMessage"><h1>Thank you!</h1>

          <p>You have updated your profile.</p><p>
          <br /></p></div>';
          header("Refresh:3;URL=../Pages/Profile.php");
        }
        else
        {

          echo '<div class="HeaderMessage"><h1>System Error</h1>

          <p class="error">Your account could not be due to a system error. We apologize for
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
      <p class="LargeBoldTitle">Edit Profile</p>

      <form action="edit_profile.php" method="post">

      <p><label>First Name: </label><input type="text" name="first_name" size="20" maxlength="20" value="<?php if
      (isset($_POST['first_name']))
      {echo $_POST['first_name'];} else {echo $fn;} ?>" /></p>

      <p><label>Last Name: </label><input type="text" name="last_name" size="20" maxlength="40" value="<?php if
      (isset($_POST['last_name'])) {echo $_POST['last_name'];} else {echo $ln;} ?>" /></p>

      <p><label>Email Address:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label><input type="text" name="email" size="20" maxlength="60" value="<?php if
      (isset($_POST['email'])) {echo $_POST['email'];} else {echo $e;} ?>" /> </p>

        <p class="BasicCenter"><input class="BigButton" type="submit" name="submit" value="Update" /></p>

      </form>
    </div>
    <p class="SmallTitle">Change Password</p>
    <p class="BasicCenter"><a href="edit_password.php"><input class="BigButton" type="submit" name="submit" value="Update Password" /></a></p>
    <div class="BasicTopPadding"><a href="../Pages/Profile.php">Go Back</a></div>
  </main>

      <?php include ('../Pages/Footer.html'); ?>

  </body>
</html>
