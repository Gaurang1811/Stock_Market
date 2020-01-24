<?php

  if(isset($_SESSION['logged_on']))
  {
    $user_id = $_SESSION['logged_on'];
    require 'db_connect.php';
    $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $customer = $row['firstname'];
    $gender = $row['gender'];
  }
  else
  {
    echo '<script>alert("Login Required !");</script>';
    echo '<script>window.location = "/stocker/login.php";</script>';
  }


  $sql = "SELECT * FROM user_stock_history WHERE user_id = $user_id ORDER BY hit DESC";
  $result = $conn->query($sql);

  if(mysqli_num_rows($result) == 0)
  {
    echo "<tr>";
    echo "<td colspan = 3 style = 'text-align:center;font-size:18px'>You have no history</td>";
    echo "</tr>";
  }
  else
  {
    while($row = $result->fetch_assoc())
    {
      echo "<tr>";
      echo "<td>";
      echo $row['stock_name'];
      echo "</td>";
      echo "<td>";
      echo 'You have visited this stock '. $row['hit'] .' times';
      echo "</td>";
      echo "<td>";
      echo "<a href = '#'>View Graph</a>";
      echo "</td>";
      echo "</tr>";
    }
  }









      //echo "<td value = '".$row['name']."'>".$row['security_code']."</option>";



 ?>
