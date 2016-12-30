<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
  </head>

  <?php include ('Header.html');  ?>

  <body>
      <div class="HeaderMessage">
        <h1>You Are Not Logged In</h1>
      <p>You must be logged in to access this page.</p>
      <p><br /></p></div>

  </body>

  <?php
  header("Refresh:3;URL=../Pages/HomePage.php");
  include ('Footer.html');
  ?>
</html>
