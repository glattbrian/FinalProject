<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xlmns="http://www.w3.org/1999/xhtml" xml:lang="en" lamg="en">
<title>Products</title>
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
  $q = "SELECT acc_type AS admin FROM Users WHERE user_id=$ui";
  $r = @mysqli_query ($dbc, $q);
  $row = @mysqli_fetch_array ($r, MYSQLI_ASSOC);
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
             <a href="Profile.php">Profile</a>
           </li>
         </ul>
       </nav>
     </header>
    <?php
    echo '<h1>Active Products</h1>';

    $display = 2;
    $size_range=2;

    $q = "SELECT COUNT(app_id) FROM Products";
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
      if($page_number>=$pages)
      {
        $page_number=-1;
      }
    }
    else
    {
    	$start = 0;
      $page_number=0;
    }
    if (isset($_GET['s']) && is_numeric($_GET['s']))
    {
    	$sort=1;
      $sortTextA='?s=1';
      $sortTextB='&s=1';
    }
    else
    {
    	$sort=0;
      $sortTextA='';
      $sortTextB='';
    }

    if($sort==1)
    {
      $q = "SELECT name AS name, DATE_FORMAT(cre_date, '%M % %D %
        %Y') AS dr, link AS link, app_id FROM Products ORDER BY name ASC LIMIT $start, $display";
    }
    else
    {
      $q = "SELECT name AS name, DATE_FORMAT(cre_date, '%M % %D %
        %Y') AS dr, link AS link, app_id FROM Products ORDER BY cre_date ASC LIMIT $start, $display";
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
        if($ad>=1)
        {
          if($sort==1)
          {
            if($page_number!=0)
            {
              echo '<b>Name</b>
              </td>
              <td align="left">
              <b><a href="UserProducts.php?p=' . $page_number . '">Date Published</a></b>
              </td>
              <td align="left">
              <b>Delete</b>
              </td>
              <td align="left">
              <b>Link</a></b>
              </td></tr>';
            }
            else
            {
              echo '<b>Name</b>
              </td>
              <td align="left">
              <b><a href="UserProducts.php">Date Published</a></b>
              </td>
              <td align="left">
              <b>Delete</b>
              </td>
              <td align="left">
              <b></b>
              </td></tr>';
            }
          }
          else
          {
            if($page_number!=0)
            {
              echo '<b><a href="UserProducts.php?p=' . $page_number . '&s=1">Name</a></b>
              </td>
              <td align="left">
              <b>Date Published</b>
              </td>
              <td align="left">
              <b>Delete</b>
              </td>
              <td align="left">
              <b>Link</b>
              </td></tr>';
            }
            else
            {
              echo '<b><a href="UserProducts.php?s=1">Name</a></b>
              </td>
              <td align="left">
              <b>Date Published</b>
              </td>
              <td align="left">
              <b>Delete</b>
              </td>
              <td align="left">
              <b>Link</b>
              </td></tr>';
            }
          }

          while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
          {
            $link=$row['link'];
            echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['dr'] . '</td>
            <td align="left">' . '<a href="../PHP/DeleteProduct.php?id=' . $row['app_id'] .  '">Delete</a>' . '</td>
            <td align="left">' . '<a href=' . $link . ' target="_blank">Link</a>' . '</td>
            </tr>';
          }
          echo '</table>';

          echo '<p class="LargeBoldTitleTwo">Register New Product</p><p class="BasicLeftAlign"><a href="../PHP/Register_Product.php"><input class="BigButton" type="submit" name="submit" value="Register"/></a></p>';
        }
        else
        {
          if($sort==1)
          {
            if($page_number!=0)
            {
              echo '<b>Name</b>
              </td>
              <td align="left">
              <b><a href="UserProducts.php?p=' . $page_number . '">Date Published</a></b>
              </td>
              <td align="left">
              <b></b>
              </td></tr>';
            }
            else
            {
              echo '<b>Name</b>
              </td>
              <td align="left">
              <b><a href="UserProducts.php">Date Published</a></b>
              </td>
              <td align="left">
              <b></b>
              </td></tr>';
            }
          }
          else
          {
            if($page_number!=0)
            {
              echo '<b><a href="UserProducts.php?p=' . $page_number . '&s=1">Name</a></b>
              </td>
              <td align="left">
              <b>Date Published</b>
              </td>
              <td align="left">
              <b>Link</b>
              </td></tr>';
            }
            else
            {
              echo '<b><a href="UserProducts.php?s=1">Name</a></b>
              </td>
              <td align="left">
              <b>Date Published</b>
              </td>
              <td align="left">
              <b>Link</b>
              </td></tr>';
            }
          }

          while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
          {
            $link=$row['link'];
            echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['dr'] . '</td>
            <td align="left">' . '<a href=' . $link . ' target="_blank">Link</a>' . '</td>
            </tr>';
          }
          echo '</table>';
      }

        mysqli_free_result ($r);

        if ($pages > 1)
        {
        	echo '<br /><p>';

        	if ($page_number!=0)
          {
            if($page_number==1)
            {
              echo '<a href="UserProducts.php' . $sortTextA . '">Previous</a> ';
            }
            else
            {
              $temp=$page_number-1;
              echo '<a href="UserProducts.php?p=' . $temp . $sortTextB . '">Previous</a> ';
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
              echo '<a href="UserProducts.php' . $sortTextA . '">' . $temp . '</a> ';
            }
        		else if ($i != $page_number)
            {
              $temp=$i+1;
        			echo '<a href="UserProducts.php?p=' . $i . $sortTextB . '">' . $temp . '</a> ';

        		}
            else
            {
        			echo $i+1 . ' ';
        		}
        	}

        	if ($page_number != $pages-1)
          {
            $temp=$page_number+1;
        		echo '<a href=UserProducts.php?p=' . $temp . $sortTextB . '> Next</a>';
        	}
        	echo '</p>';
        }
      }
      else
      {
        echo '<p class="error">There are currently no registered products.</p>';
        if($ad>=1)
        {
          echo '<p class="LargeBoldTitleTwo">Register New Product</p><p class="BasicLeftAlign"><a href="../PHP/Register_Product.php"><input class="BigButton" type="submit" name="submit" value="Register"/></a></p>';
        }
      }
      mysqli_close($dbc);
      ?>
    </main>
  </body>
  <?php
  include ('Footer.html'); ?>
</html>
