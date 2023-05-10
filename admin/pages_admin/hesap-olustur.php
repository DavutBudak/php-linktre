<?php
if($cikti->uye_yetki == 0){

    header("Location:index.php");
 }else{


if ($_POST) {

 $uye_password=$_POST['uye_password'];
 $uye_password2=$_POST['uye_password2']; 
 $uye_kadi=$_POST['uye_kadi'];

 
 if (empty($uye_kadi) || empty($uye_password)|| empty($uye_password2) ) {
    echo '
    <section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">
                 Yıldızlı alanlar boş bırakılamaz.
                </div> </div> </div> </div> </div> </section>';

        
  }

else { 


if ($uye_password ==$uye_password2) {


    $ayni_uye_varmi_kadi = $conn -> prepare("SELECT * FROM uyegiris WHERE BINARY uye_kadi = ?");
    $ayni_uye_varmi_kadi -> execute(array($uye_kadi));
    if($ayni_uye_varmi_kadi -> rowCount()){
        echo '
        <section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">
                Bu kullanıcı Adı Daha Önce Alınmış. Lütfen Farklı Bilgiler İle Devam Ediniz.
                </div> </div> </div> </div> </div> </section>';
       }   else{
           
  
 

    $stmt = $conn->prepare("INSERT INTO uyegiris (uye_kadi, uye_password)   
    VALUES ( :uye_kadi, :uye_password)");
   $stmt->bindParam(':uye_kadi', $uye_kadi);
    $stmt->bindParam(':uye_password', $uye_password); 
      $stmt->execute();

      $uye_getir = $conn->prepare("SELECT * FROM uyegiris WHERE uye_kadi = ?");
      $uye_getir->execute(array($uye_kadi));
      if ($uye_getir) {
        $uye = $uye_getir->fetch(PDO::FETCH_OBJ);
      }         

      $firma_id = $uye->id;
$smhesaplar = array(
    array("INSTAGRAM", "https://www.instagram.com/", "fab fa-instagram", "0"),
    array("TWITTER", "https://twitter.com/", "fab fa-twitter", "0"),
    array("FACEBOOK", "https://www.facebook.com/", "fab fa-facebook", "0"),
    array("LINKEDIN", "https://www.linkedin.com/", "fab fa-linkedin", "0"),
    array("YOUTUBE", "https://www.youtube.com/", "fab fa-youtube", "0")
);

$smhesapekle = $conn->prepare("INSERT INTO smhesapbilgileri (firma_id, smhesapadi, smhesapurl, smhesapicon, smhesapdurum) VALUES (?,?,?,?,?)");

foreach ($smhesaplar as $smhesap) {
    $smhesapekle->execute(array($firma_id, $smhesap[0], $smhesap[1], $smhesap[2], $smhesap[3]));
}


echo '<section class="content">
<div class="container-fluid">
    <div class="block-header">
        <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">   <div class="alert alert-success"  style="text-align:center;"  role="alert">
        Değişiklikler kayıt edildi. Listeye yönlendirilecek.
        </div> </div> </div> </div> </div> </section>';

} } else {

echo '<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">
                Lütfen Şifrelerin Aynı Olduğundan Emin Olunuz.
                </div> </div> </div> </div> </div> </section>';

}
}
}

?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Yeni Hesap Oluştur</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index.php"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Hesap Oluştur</li>
                    </ul>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12">
             
                </div>
            </div>
        </div>
     
        <!-- Advanced Form Example With Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                
                    </div>                    
                    <form id="wizard_with_validation" method="POST">
                        <h3>Hesap Bilgileri</h3>
                        <fieldset>
                            <div class="form-group form-float">
                                <input type="text" class="form-control" placeholder="Kullanıcı Adı *" name="uye_kadi" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="password" class="form-control" placeholder="Şifre *" name="uye_password" id="password" required>
                            </div>
                            <div class="form-group form-float">
                                <input type="password" class="form-control" placeholder="Şifre Doğrulama *" name="uye_password2" id="password" required>
                            </div>
                            <div class="form-group form-float">
                            <input style="width:100%" type="submit" class="btn btn-primary btn-round waves-effect m-t-20" value="Hesap Oluştur" >
                            </div>
                        </fieldset>
                        
                    </form>
                </div>
            </div>
        </div>
        <!-- #END# Advanced Form Example With Validation --> 
    </div>
</section>
<?php } ?>