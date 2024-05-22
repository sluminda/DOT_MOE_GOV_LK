<?php 
if(isset($_POST["submit"]) ){

    $userName = $_POST['uname'];
    $userPassword = $_POST['pwd'];

    $connection =  mysqli_connect('root','root','','dot_moe');

    if ($connection -> connect_error) {
        die("Connection failed: " . $connection -> connect_error);
      }

      $query = "SELECT id, firstname, lastname FROM MyGuests";
    $result = $conn->query($sql);
}

    
?>