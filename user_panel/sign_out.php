<?php

  session_start();
  session_destroy();
  
  echo '<script>window.location = "/stocker/login.php";</script>';

 ?>
