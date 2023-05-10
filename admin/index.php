


<?php
   require_once ('admin_init.php'); 
   if(!$_SESSION["login"]){
      header("Location:giris.php");
   }else{
      include 'pages_admin/headfooter/header.php';
      include 'admin_get.php';
      include 'pages_admin/headfooter/footer.php';
   }
  
?>
