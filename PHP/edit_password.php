<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head><meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" /> <title>Edit Password</title></head>
  <body>
    <?php

    $page_title = 'Edit Password';
    include ('../Pages/Header.html');
    require ('../../../mysqli_connect.php');
    if (!isset($_COOKIE['user_id']))
    {
      require ('login_functions.inc.php');
      redirect_user('../Pages/MustBeLoggedIn.php');
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $errors = array();

      if (!empty($_POST['pass0']))
      {
        $po = mysqli_real_escape_string($dbc, trim($_POST['pass0']));
        $po=SHA1($po);
        $id=$_COOKIE['user_id'];
        $q = "SELECT pass
        FROM Users WHERE user_id='$id'";

        $r = @mysqli_query ($dbc, $q);
        $row = @mysqli_fetch_array ($r, MYSQLI_ASSOC);
        if ($po!=$row['pass'])
        {
          $errors[] = 'You have entered your current password incorrectly.';
        }
      }
      else
      {
        $errors[] = 'You forgot to enter your current password.';
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
          $p=SHA1($p);
        }
      }
      else
      {
        $errors[] = 'You forgot to enter your password.';
      }

      if (empty($errors))
      {
        $q = "UPDATE Users SET pass='$p' WHERE user_id='$id'";

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

      <form action="edit_password.php" method="post">

      <p><label>Current Password: </label><input type="password" name="pass0" size="20" maxlength="60" value='' /></p>

      <p><label>New Password: </label><input type="password" name="pass1" size="20" maxlength="60" value='' /></p>

      <p><label>Confirm New Password: </label><input type="password" name="pass2" size="20" maxlength="60" value='' /> </p>

        <p class="BasicCenter"><input class="BigButton" type="submit" name="submit" value="Update" /></p>

      </form>
    </div>
    <div class="BasicTopPadding"><a href="../Pages/Profile.php">Go Back</a></div>
  </main>

      <?php include ('../Pages/Footer.html'); ?>

  </body>
</html>
