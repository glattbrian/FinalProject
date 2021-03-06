<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
<title>Delete Product</title>
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />


  </head>
<main id="pageContainer">
  <?php
  include ('../Pages/Header.html');
  require('../../../mysqli_connect.php');
  require ('login_functions.inc.php');
  echo '<h1>Delete a Product</h1>';
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

  if ( (isset($_GET['id'])) && (is_numeric ($_GET['id'])) )
  {
    $id = $_GET['id'];
  }
  else if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) )
  {
    $id = $_POST['id'];
  }
  else
  {
    echo '<p class="error">This page has been accessed in error.</p>';
    header("Refresh:3;URL=../Pages/UserProducts.php");
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if ($_POST['sure'] == 'Yes')
    {
      $q = "DELETE FROM Products WHERE app_id=$id LIMIT 1";
      $r = @mysqli_query ($dbc, $q);
      if (mysqli_affected_rows($dbc) == 1)
      {
        echo '<p>The product has been deleted.</p>';
        header("Refresh:3;URL=../Pages/UserProducts.php");
      }
      else
      {
        echo '<p class="error">The product could not be deleted due to a system error.</p>';
        echo '<p>' . mysqli_error($dbc) . '<br/>Query: ' . $q . '</p>';
      }
    }
    else
    {
      echo '<p>The product has NOT been deleted.</p>';
      header("Refresh:3;URL=../Pages/UserProducts.php");
    }
  }
  else
  {
    $q = "SELECT name AS name FROM Products WHERE app_id=$id";

    $r = @mysqli_query ($dbc, $q);

    if (mysqli_num_rows($r) == 1)
    {
      $row = mysqli_fetch_array ($r, MYSQLI_NUM);
      echo "<h3>Name: $row[0]</h3>Are you sure you want to delete
      this product?";
      echo '<form action="DeleteProduct.php" method="post">

      <input type="radio" name="sure"
      value="Yes" /> Yes

      <input type="radio" name="sure"
      value="No" checked="checked" /> No

      <input type="submit" name="submit"
      value="Submit" />

      <input type="hidden" name="id"
      value="' . $id . '" />

      </form>';
    }
    else
    {
      header("Refresh:3;URL=../Pages/UserProducts.php");
    }
  }
  mysqli_close($dbc);
 ?>
 </main>
 <?php
  include ('../Pages/Footer.html'); ?>
</html>
