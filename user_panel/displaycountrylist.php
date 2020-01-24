<?php

  require 'db_connect.php';
  $sql = "SELECT * FROM countrylist";
  $result = $conn->query($sql);
  echo '<select name = "country" class="form-control">';
  echo "<option disabled selected>Please select your country</option>";
  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      echo "<option value = '".$row['Name']."'>".$row['Name']."</option>";
    }
  }
  echo '</select>';
 ?>
