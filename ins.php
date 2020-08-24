<?php
session_start();
$name = $_POST['name'];
$size = $_POST['size'];
$role = $_POST['role'];
$requirements = $_POST['requirements'];
$password = $_POST['password'];

if (!empty($name) || !empty($size) || !empty($role)|| !empty($requirements)) {
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "login";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT name From register Where name = ? Limit 1";
     $INSERT = "INSERT Into register (name, size, role , requirements, password) values(?, ?, ?, ?, ?)";
     // Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $name);
     $stmt->execute();
     $stmt->bind_result($name);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sisss", $name, $size, $role, $requirements, $password);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this name";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>