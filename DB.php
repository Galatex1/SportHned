<?php
         $dbhost = 'localhost';
         $dbuser = 'sporthnedcz';
         $dbpass = 'Snapdragon3000';
         
         $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
   
         if(! $conn ){
            die('Could not connect: ' . mysqli_error());
         }
         echo 'Connected successfully';     
         mysqli_close($conn);
?>