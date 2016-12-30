<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />

    <?php

    if (!isset($_COOKIE['user_id']))
    {
      echo '<p class="LoginText">You are not Logged In (<a href="../PHP/login.php">Login</a>)</p>';
    }
    else
    {
      echo '<p class="LoginText">(<a href="../PHP/logout.php">Logout</a>)</p>
      <header>
          <nav class="main-nav">
            <ul class="basicMenu">
              <li class="menu-item">
                <a href="UserProducts.php">Products</a>
              </li>
              <li class="menu-item">
                <a href="Profile.php">Profile</a>
              </li>
            </ul>
          </nav>
      </header>';
    }
    ?>
  </head>
</html>
