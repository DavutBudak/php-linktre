
<?php
// UYE GIRISI yapılmışsa  SAYFASINA YONLENDIR

include "admin_init.php";
if (@$_SESSION["login"]) {
    header("Location:index.php");
    

}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<title>Admin Giriş</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="assets/giriscss/icon-font.min.css">
<link rel="stylesheet" type="text/css" href="assets/giriscss/util.css">
<link rel="stylesheet" type="text/css" href="assets/giriscss/main.css">
<script src="https://kit.fontawesome.com/1d31c2c74b.js" crossorigin="anonymous"></script>

<meta name="robots" content="noindex, follow">
</head>

    

          <?php
if ($_POST) {
    $kullanici_adi = htmlspecialchars(addslashes(strip_tags(trim($_POST["kullanici_adi"]))));
    $sifre = htmlspecialchars(addslashes(strip_tags(trim($_POST["sifre"]))));
    if (!$kullanici_adi || !$sifre) {
        echo '
        <section class="content">
<div class="container-fluid">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center ; padding-right:0px !important;  padding-left:0px !important;   margin: 0px !important;   padding: 0px !important;" role="alert">
            Lütfen kullanıcı adı ve şifre alanını doldurunuz.
            </div> </div> </div> </div> </div> </section>';
    } else {
        $stmt = $conn->prepare("SELECT * FROM uyegiris WHERE BINARY uye_kadi = ? AND BINARY uye_password = ?");
        $stmt->execute(array($kullanici_adi, $sifre));
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['uye_hesap_durum'] == 1) {
                echo '
                <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center ; padding-right:0px !important;  padding-left:0px !important;   margin: 0px !important;   padding: 0px !important;" role="alert">
                    Hesabınız pasif durumda olduğu için giriş yapamazsınız.
                    </div> </div> </div> </div> </div> </section>';
            } else {
                session_start();
                $_SESSION["login"] = true;
                $_SESSION["uye"] = $row['uye_kadi'];
                $_SESSION["id"] = $row['id'];
                header("Location: index.php");
                exit;
            }
        } else {
            echo '
            <section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger"  style="text-align:center ; padding-right:0px !important;  padding-left:0px !important;   margin: 0px !important;   padding: 0px !important;" role="alert">
                Lütfen kullanıcı adı ve şifrenizi doğru giriniz.
                </div> </div> </div> </div> </div> </section>';
        }
    }
}
            

          ?>
    


<div class="limiter">
<div class="container-login100" style="background-image: url('assets/giriscss/img-01.jpg');">
<div class="wrap-login100 p-t-190 p-b-30">
<form class="login100-form validate-form" method="POST" action="">
<div class="login100-form-avatar">
<img src="assets/giriscss/avatar.jpg" alt="AVATAR">
</div>
<span class="login100-form-title p-t-20 p-b-45">
<b>Admin</b>
</span>
<div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
<input class="input100" type="text" name="kullanici_adi" placeholder="Kullanıcı Adı">
<span class="focus-input100"></span>
<span class="symbol-input100">
<i class="fa fa-user"></i>
</span>
</div>
<div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
<input class="input100" type="password" name="sifre" placeholder="Şifre">
<span class="focus-input100"></span>
<span class="symbol-input100">
<i class="fa fa-lock"></i>
</span>
</div>
<div class="container-login100-form-btn p-t-10">
<button class="login100-form-btn">
Giriş Yap
</button>
</div>
</form>
<footer style="margin-top:30px;">
    <div> <p style="text-align:center; color:white;"> <b> COPYRIGHT &copy; - 2023 </b></p> </div>
</footer>
</div>
</div>
</div>
