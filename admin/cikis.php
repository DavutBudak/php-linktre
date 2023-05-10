
<?php
// UYE GIRISI YAPILMAMISSA GIRIS SAYFASINA YONLENDIR
include "admin_init.php";

?>
<?php

unset($_SESSION['login']);
header("Refresh:0; url=giris.php");
?>
