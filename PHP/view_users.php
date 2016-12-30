<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <title>Assignment1Glatt</title></head>
  <body>
    <?php

    $page_title = 'View the Current Users';

    include ('includes/header.html');

    echo '<h1>Registered Users</h1>';

    require ('../../../mysqli_connect.php');

    $q = "SELECT CONCAT(last_name, ', ', first_name) AS name, DATE_FORMAT(reg_date, '%M %
      %Y') AS dr FROM User ORDER BY reg_date ASC";

      $r = @mysqli_query ($dbc, $q); // Run the query.

      $num = mysqli_num_rows($r);      if($num>0)
      {        echo "<p>There are currently $num registered users.</p>\n";

        echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">

        <tr><td align="left"><b>Name</b></td><td align="left"><b>Date Registered</b></td></tr>

        ';

        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
        {
          echo '<tr><td align="left">' . $row['name'] . '</td><td align="left">' . $row['dr'] .
          '</td></tr>
          ';
        }
        echo '</table>';

        mysqli_free_result ($r);
      }
      else
      {
        echo '<p class="error">There are currently no registered users.</p>';
      }

      mysqli_close($dbc);
      include ('includes/footer.html');
    ?>
  </body>
</html>
