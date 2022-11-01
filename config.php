<?php
  
  $servername = "localhost";
  $username = "root";
  $password = "";

// Create connection
   $conn = mysqli_connect($servername, $username, $password, 'coffeelock');

    if(!$conn) {
        echo 'Error '. mysqli_connect_error();
    }

?>