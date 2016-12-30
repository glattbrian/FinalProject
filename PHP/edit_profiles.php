<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
<title>Edit Users</title>
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />


  </head>

  <?php
  require ('login_functions.inc.php');
  require ('../../../mysqli_connect.php');
  if (!isset($_COOKIE['user_id']))
  {
    redirect_user();
  }
  include ('../Pages/Header.html');
  $ui=$_COOKIE['user_id'];
  $q = "SELECT acc_type AS admin FROM Users WHERE user_id=$ui";
  $r = @mysqli_query ($dbc, $q);
  $row = @mysqli_fetch_array ($r, MYSQLI_ASSOC);
  $ad=$row['admin'];
  if($ad<1)
  {
    redirect_user();
  }
 ?>
 <body>
   <main id="pageContainer">

    <?php
    echo '<h1>Active Users</h1>';

    $display = 5;
    $size_range=3;

    $q = "SELECT COUNT(user_id) FROM Users";
  	$r = @mysqli_query ($dbc, $q);
  	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
  	$records = $row[0];

  	// Calculate the number of pages...
  	if ($records > $display)
    { // More than 1 page.
  		$pages = ceil ($records/$display); //ceil function used to round up
  	}
    else
    {
  		$pages = 1;
  	}

    if (isset($_GET['p']) && is_numeric($_GET['p']))
    {
    	$start = $_GET['p']*$display;
      $page_number=$_GET['p'];
      $page_text='?p=' . $_GET['p'];
      $currentSortText='&s=';
      if($page_number>=$pages)
      {
        $page_number=-1;
      }
    }
    else
    {
      $page_text='';
      $currentSortText='?s=';
    	$start = 0;
      $page_number=0;
    }
    if (isset($_GET['s']) && is_numeric($_GET['s']))
    {
    	$sort=$_GET['s'];
      $sortTextA='?s=' . $_GET['s'];
      $sortTextB='&s=' . $_GET['s'];
    }
    else
    {
    	$sort=0;
      $sortTextA='';
      $sortTextB='';
    }

    if($sort==0)
    {
      $q = "SELECT first_name AS first_name, last_name AS last_name, email AS email, DATE_FORMAT(reg_date, '%M % %D %
        %Y') AS dr, acc_type AS admin, user_id FROM Users ORDER BY first_name ASC LIMIT $start, $display";
    }
    else if($sort==1)
    {
      $q = "SELECT first_name AS first_name, last_name AS last_name, email AS email, DATE_FORMAT(reg_date, '%M % %D %
        %Y') AS dr, acc_type AS admin, user_id FROM Users ORDER BY last_name ASC LIMIT $start, $display";
    }
    else if($sort==2)
    {
      $q = "SELECT first_name AS first_name, last_name AS last_name, email AS email, DATE_FORMAT(reg_date, '%M % %D %
        %Y') AS dr, acc_type AS admin, user_id FROM Users ORDER BY email ASC LIMIT $start, $display";
    }
    else
    {
      $q = "SELECT first_name AS first_name, last_name AS last_name, email AS email, DATE_FORMAT(reg_date, '%M % %D %
        %Y') AS dr, acc_type AS admin, user_id FROM Users ORDER BY reg_date ASC LIMIT $start, $display";
    }

      $r = @mysqli_query ($dbc, $q); // Run the query.

      $num = mysqli_num_rows($r);

      if($page_number<0)
      {
        echo '<p class="error">Page does not exist.</p>';
      }
      else if($num>0)
      {
        echo '<table align="center" cellspacing="3" cellpadding="3" width="75%"><tr></td><td align="left">';

        if($sort==0)
        {
          echo '<b>First Name</b></td><td align="left">';
        }
        else
        {
          echo '<b><a href="edit_profiles.php' . $page_text . '">First Name</b></td><td align="left">';
        }

        if($sort==1)
        {
          echo '<b>Last Name</b></td><td align="left">';
        }
        else
        {
          echo '<b><a href="edit_profiles.php' . $page_text . $currentSortText . '1">Last Name</b></td><td align="left">';
        }

        if($sort==2)
        {
          echo '<b>Email</b></td><td align="left">';
        }
        else
        {
          echo '<b><a href="edit_profiles.php' . $page_text . $currentSortText . '2">Email</b></td><td align="left">';
        }

        if($sort==3)
        {
          echo '<b>Registration Date</b></td><td align="left">';
        }
        else
        {
          echo '<b><a href="edit_profiles.php' . $page_text . $currentSortText . '3">Registration Date</b></td><td align="left">';
        }

        echo '<b>Delete</b></td></tr>';

        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
        {
          //if($row['admin']<1)
          //{
          echo '<tr>
          <td align="left">' . $row['first_name'] . '</td>
          <td align="left">' . $row['last_name'] . '</td>
          <td align="left">' . $row['email'] . '</td>
          <td align="left">' . $row['dr'] . '</td>';
          if($row['admin']<1)
          {
            echo '<td align="left">' . '<a href="delete_profile.php?id=' . $row['user_id'] .  '">Delete</a>' . '</td>';
          }
          else
          {
            echo '<td align="left">Admin</td>';
          }
          echo '</tr>';
        }
        echo '</table>';

        mysqli_free_result ($r);

        if ($pages > 1)
        {
        	echo '<br /><p>';

        	if ($page_number!=0)
          {
            if($page_number==1)
            {
              echo '<a href="edit_profiles.php' . $sortTextA . '">Previous</a> ';
            }
            else
            {
              $temp=$page_number-1;
              echo '<a href="edit_profiles.php?p=' . $temp . $sortTextB . '">Previous</a> ';
            }
        	}
          $lower_range=0;
          $upper_range=$pages;
          if($page_number-$size_range>0)
          {
            $lower_range=$page_number-$size_range;
          }
          if($page_number+$size_range<$pages-1)
          {
            $upper_range=$page_number+$size_range+1;
          }
        	for ($i = $lower_range; $i < $upper_range; $i++)
          {
            if($i==0 && $i!=$page_number)
            {
              $temp=$i+1;
              echo '<a href="edit_profiles.php' . $sortTextA . '">' . $temp . '</a> ';
            }
        		else if ($i != $page_number)
            {
              $temp=$i+1;
        			echo '<a href="edit_profiles.php?p=' . $i . $sortTextB . '">' . $temp . '</a> ';

        		}
            else
            {
        			echo $i+1 . ' ';
        		}
        	}

        	if ($page_number != $pages-1)
          {
            $temp=$page_number+1;
        		echo '<a href=edit_profiles.php?p=' . $temp . $sortTextB . '> Next</a>';
        	}
        	echo '</p>';
        }
      }
      else
      {
        echo '<p class="error">There are currently no registered users.</p>';
      }

      mysqli_close($dbc);
      ?>
      <div class="BasicTopPadding"><a href="../Pages/Profile.php">Go Back</a></div>
    </main>
  </body>
  <?php
  include ('Footer.html'); ?>
</html>
