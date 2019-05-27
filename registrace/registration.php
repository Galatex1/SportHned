<?php

include "../DB.php";


$fName = $_POST['fname'];
$lName = $_POST['lname'];
$email = $_POST['email'];
$pass = $_POST['pass'];




if(isset($fname) && isset($lname)  && isset($email) && isset($pass))
{

}
else
  echo "Chyba pri registraci";



>