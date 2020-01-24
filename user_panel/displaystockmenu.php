<?php

  $sql = "SELECT * FROM stockname";
  $result = $conn->query($sql);

  echo "<input placeholder = 'Please select the stock' style = 'padding:0.94rem;font-size:13px' class='form-control form-control-lg' required type = 'text' id = 'stock_name' name = 'stock_name' list = 'stock_list'>";
  echo "<datalist id = 'stock_list'>";
  echo "<option disabled selected>Please select the stock</option>";
  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      echo "<option value = '".$row['name']."'>".$row['security_code']."</option>";
    }
  }
  echo "</datalist>";

/*
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
*/
 ?>
