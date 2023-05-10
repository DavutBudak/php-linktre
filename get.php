<?php
    if(!$_GET){
        include 'html/index.php';
    }else{
        switch(@$_GET["slug"]){
            // case alanında url yolu tanımlanır, include sayfa yeri gösterilir.
            case 'clicksus': include 'html/index.php';break;
                 
        default:include 'html/index.php';break;
        }
    }
?>


