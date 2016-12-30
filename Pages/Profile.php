<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
<title>Profile</title>
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />


  </head>

  <?php
  require ('../PHP/login_functions.inc.php');
  require ('../../../mysqli_connect.php');
  if (!isset($_COOKIE['user_id']))
  {
    redirect_user('MustBeLoggedIn.php');
  }
  include ('Header.html');
  $ui=$_COOKIE['user_id'];
  $q = "SELECT first_name AS first_name, last_name AS last_name, email AS email, DATE_FORMAT(reg_date, '%M % %D %
    %Y') AS reg_date, acc_type AS admin, user_id FROM Users WHERE user_id=$ui";
  $r = @mysqli_query ($dbc, $q);
  $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
  $ad=$row['admin'];
 ?>
 <body>
   <main id="pageContainer">
     <p class="LoginText">(<a href="../PHP/logout.php">Logout</a>)</p>
     <header>
       <nav class="main-nav">
         <ul class="basicMenu">
           <li class="menu-item">
             <a href="HomePage.php">Home</a>
           </li>
           <li class="menu-item">
             <a href="UserProducts.php">Products</a>
           </li>
         </ul>
       </nav>
     </header>
    <?php
    echo '<h1>Your Profile</h1>';


    echo '<table align="center" cellspacing="3" cellpadding="3" width="75%"><tr></td>
    <td align="left">
    <b>First Name</b>
    </td>
    <td align="left">
    <b>Last Name</b>
    </td>
    <td align="left">
    <b>Email</b>
    </td>
    <td align="left">
    <b>Registration Date</a></b>
    </td></tr>';

    echo '<tr>
    <td align="left">' . $row['first_name'] . '</td>
    <td align="left">' . $row['last_name'] . '</td>
    <td align="left">' . $row['email'] .  '</a>' . '</td>
    <td align="left">' . $row['reg_date'] . '</td>
    </tr>
    </table>';
    ?>

     <div class="BasicInline"><p class="LargeBoldTitleTwo">Update Profile</p><p class="BasicLeftAlign"><a href="../PHP/edit_profile.php"><input class="BigButton" type="submit" name="submit" value="Edit Profile"/></a></p></div>

     <?php
     if($ad>=1)
     {
       echo '<div class="BasicInlineTwo"><p class="LargeBoldTitleThree">View Profiles</p><p class="BasicLeftAlign"><a href="../PHP/edit_profiles.php"><input class="BigButton" type="submit" name="submit" value="View Profiles"/></a></p></div>';
     }
     ?>

    </main>
  </body>
  <?php include ('Footer.html'); ?>
</html>
