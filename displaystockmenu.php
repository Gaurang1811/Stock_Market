<?php

  $sql = "SELECT * FROM stockname";
  $result = $conn->query($sql);
  echo '<select name = "security_code" class="form-control form-control-lg" required>';
  echo "<option disabled selected>Please select the stock</option>";
  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      echo "<option value = '".$row['security_code']."'>".$row['name']."</option>";
    }
  }
  echo '</select>';
 ?>
