<?php $urlfoto = 'https://'.$_SERVER['SERVER_NAME'].'/linktreclicksus/admin/';
// Slug değerini al
@$slug = $_GET["slug"];

if($slug == NULL){$slug ="clicksus";}

// slug değerine göre frontbilgi tablosundaki ilgili verileri çek
$sql = "SELECT frontbilgi.*, uyegiris.slug FROM frontbilgi  JOIN uyegiris ON uyegiris.id = frontbilgi.firma_id   WHERE uyegiris.slug = :slug";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':slug', $slug);
$stmt->execute();
$ayar = $stmt->fetch(PDO::FETCH_OBJ);


@$idgirisyapan=$ayar->firma_id;
$stmtgiris = $conn->prepare("SELECT * FROM uyegiris WHERE id = :id");
$stmtgiris->bindParam(':id', $idgirisyapan);
$stmtgiris->execute();
$resultgiris = $stmtgiris->fetch(PDO::FETCH_OBJ);
 ?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLİCKS'US</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="image/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="image/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="image/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="image/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="image/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="image/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="image/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="image/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="image/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="image/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="image/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="image/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="image/favicon-16x16.png">
    <link rel="manifest" href="image/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="image/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">    <!-- Font Awesome icons --><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <script src=""></script>
    <!-- <script src="https://kit.fontawesome.com/1d31c2c74b.js" crossorigin="anonymous"></script>  -->
    <!-- Core theme CSS -->
    <link rel="stylesheet" href="html/assets/style.css">
    <meta name="robots" content="noindex">
  </head>
  <?php  if($ayar->backimage == NULL) {$imageback = "admin/imagebackground/arkaplanfoto.jpg";} else {$imageback = "admin/".$ayar->backimage;}?> 
  <body style="background-image: url(<?php echo $imageback;?>) !important;">


<div></div>