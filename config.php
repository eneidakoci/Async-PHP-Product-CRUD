<?php
//lidhja e php me mysql
   $conn = mysqli_connect('localhost', 'root', '','ecommerce', 3307);

   if (!$conn) {
      die('Lidhja me databazen nuk u realizua:' . mysqli_connect_error());
   }
?>

