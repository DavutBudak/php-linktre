<?php
    if(!$_GET){
        if($cikti->uye_yetki == 0){ 
        include 'pages_admin/anasayfa.php';}else{ include 'pages_admin/anasayfa-admin.php';}
    }else{
        switch($_GET["adminsayfa"]){
            // case alanında url yolu tanımlanır, include sayfa yeri gösterilir.
           
            case 'anasayfa': include 'pages_admin/anasayfa.php';break;
            case 'hesap-ekle': include 'pages_admin/hesapekle.php';break;
            case 'sm-hesap-ekle': include 'pages_admin/smhesapekle.php';break;
            case 'hesaplar': include 'pages_admin/hesaplar.php';break;
            case 'hesap-olustur': include 'pages_admin/hesap-olustur.php';break;
            case 'hesapduzenle': include 'pages_admin/duzenle/hesap_duzenle.php';break;
            case 'anasayfa-admin': include 'pages_admin/anasayfa-admin.php';break;
            default:include 'pages_admin/anasayfa.php';break;
        }
    }
?>