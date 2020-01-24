<?php
  session_start();
  if(isset($_SESSION['logged_on']))
  {
    $user_id = $_SESSION['logged_on'];
    require 'db_connect.php';
    $sql = "SELECT firstname FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $customer = $row['firstname'];
  }
  else
  {
    echo '<script>alert("Login Required !");</script>';
    echo '<script>window.location = "/stocker/login.php";</script>';
  }

  require 'db_connect.php';

    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $dateofbirth = isset($_POST['dateofbirth']) ? $_POST['dateofbirth'] : '';
    $address1 = isset($_POST['address1']) ? $_POST['address1'] : '';
    $address2 = isset($_POST['address2']) ? $_POST['address2'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';

    $sql = "UPDATE user SET firstname = '$firstname' , lastname = '$lastname' , gender = '$gender' , dateofbirth = '$dateofbirth' , address1 = '$address1' , address2 = '$address2' , state = '$state', postcode = '$postcode' , city = '$city' , country = '$country' WHERE user_id = '$user_id'";
    if(mysqli_query($conn, $sql))
    {
      echo '<script>alert("Changes Saved");</script>';
      echo '<script>window.location = "readonly_profile.php";</script>';
   }


 ?>
