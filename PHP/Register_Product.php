<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head><meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" /> <title>Registration</title></head>
  <body>
    <?php

    $page_title = 'Register';
    include ('../Pages/Header.html');
    require ('login_functions.inc.php');
    require ('../../../mysqli_connect.php');
    if (!isset($_COOKIE['user_id']))
    {
      redirect_user();
    }
    else
    {
      $ui=$_COOKIE['user_id'];
      $q = "SELECT acc_type AS admin FROM Users WHERE user_id=$ui";
      $r = @mysqli_query ($dbc, $q);
      $row = @mysqli_fetch_array ($r, MYSQLI_ASSOC);
      $ad=$row['admin'];
    }
    if($ad==0)
    {
      redirect_user();
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {

      require ('../../../mysqli_connect.php');

      $errors = array();

      if (empty($_POST['name']))
      {
        $errors[] = 'You forgot to enter the product name.';
      }
      else
      {
        $na = mysqli_real_escape_string($dbc, trim($_POST['name']));
      }

      if (empty($_POST['link']))
      {
        $errors[] = 'You forgot to enter the link.';
      }
      else
      {
        $li = mysqli_real_escape_string($dbc, trim($_POST['link']));
      }
      if (empty($errors))
      {

        $q = "INSERT INTO Products (name, cre_date, link) VALUES ('$na', NOW(), '$li')";

        $r = @mysqli_query ($dbc, $q);

        if ($r)
        {

          echo '<div class="HeaderMessage"><h1>Thank you!</h1>

          <p>' . $na . ' is registered.</p><p>
          <br /></p></div>';
          header("Refresh:3;URL=../Pages/UserProducts.php");

        }
        else
        {

          echo '<div class="HeaderMessage"><h1>System Error</h1>

          <p class="error">Product could not be registered due to a system error. We apologize for
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

      <form action="Register_Product.php" method="post">

      <p><label>Product Name:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label><input type="text" name="name" size="20" maxlength="20" value="<?php if
      (isset($_POST['name'])) echo $_POST['name']; ?>" /></p>

      <p><label>Link: </label><input type="text" name="link" size="20" maxlength="200" value="<?php if
      (isset($_POST['link'])) echo $_POST['link']; ?>" /></p>

        <p class="BasicCenter"><input class="BigButton" type="submit" name="submit" value="Register" /></p>

      </form>
    </div>
  </main>
    <?php include ('../Pages/Footer.html'); ?>
  </body>
</html>
