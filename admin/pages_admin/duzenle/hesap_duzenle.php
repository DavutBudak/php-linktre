
<?php
 require_once ('../../admin_init.php'); 
 if(!$_SESSION["login"]){
    header("Location:../../giris.php");
 }

 $firma_id_head = $_SESSION["id"];
 $sorgu = $conn->prepare('SELECT * FROM uyegiris WHERE id = :firma_id');
 $sorgu->bindParam(':firma_id', $firma_id_head, PDO::PARAM_INT);
 $sorgu->execute();
 $cikti = $sorgu->fetch(PDO::FETCH_OBJ);
 


$id = intval($_GET["id"]);
$firma_id = $_SESSION["id"];
$hesaplar = $conn->prepare("SELECT * FROM hesapbilgileri WHERE id = ?");
$hesaplar->execute(array($id));
$hesap = $hesaplar->fetch(PDO::FETCH_OBJ);


if($cikti->uye_yetki == 0){$idlogo = $_SESSION["id"];}else{$idlogo = $hesap->firma_id;}


// Frontbilgi tablosundan firma_id'si 1 olan veriyi sorgulama
$stmt = $conn->prepare("SELECT * FROM frontbilgi WHERE firma_id=:firma_id");
$stmt->bindParam(':firma_id', $idlogo);
$stmt->execute();
$frontbilgi = $stmt->fetch(PDO::FETCH_OBJ);


$url = 'https://'.$_SERVER['SERVER_NAME'];
$urlcek = $_SERVER['QUERY_STRING'];  


if(@$frontbilgi->logo == "'logo.png'" OR @$frontbilgi->logo == NULL) {$hesaplogosu= "../../../profile_av.jpg";} else {$hesaplogosu= "../../".$frontbilgi->logo;} 



if(@$hesap->firma_id == $firma_id OR $cikti->uye_yetki == 1 ) { 
    ?>


<?php
if (@$_POST['bilgidegis']) {

    $hesapadi = trim(filter_input(INPUT_POST, 'hesapadi', FILTER_SANITIZE_STRING));
    $hesapurl = trim(filter_input(INPUT_POST, 'hesapurl', FILTER_SANITIZE_STRING));
    $image_name = trim(filter_input(INPUT_POST, 'image_name', FILTER_SANITIZE_STRING));

    if (empty($hesapadi) || empty($hesapurl) || empty($image_name) ) {
        echo '
        <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">
                     Yıldızlı alanlar boş bırakılamaz.
                    </div> </div> </div> </div> </div> </section>';
      }else {
        $firma_duzenle = $conn->prepare("UPDATE hesapbilgileri SET hesapadi = ? , hesapurl = ? , image_name = ?  WHERE id = ? ");
        $firma_duzenle->execute(array($hesapadi, $hesapurl, $image_name, $id));
       
      
      if ($firma_duzenle) {
            echo '
            <section class="content">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">   <div class="alert alert-success"  style="text-align:center;"  role="alert">
                         Değişiklikler kayıt edildi. Listeye yönlendirilecek.
                         </div> </div> </div> </div> </div> </section>';
                         header("Location:../../index.php?adminsayfa=hesaplar");
                        }

}}



if (@$_POST['fotodegis']) {
      
        $file = $_FILES['file'];
    
    
    
    
     if (empty($file) ) {
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
         $resimBoyutu = $_FILES['file']['size']; // resim boyutunu öğrendik
         if ($resimBoyutu > (1024 * 1024 * 3)) {
             //buradaki işlem aslında bayt, kilobayt ve mb formülüdür.
             //2 rakamını mb olarak görün ve kaç yaparsanız o mb anlamına gelir.
             //Örn: (1024 * 1024 * 3) => 3MB / (1024 * 1024 * 4) => 4MB
    
             echo ' <section class="content">
             <div class="container-fluid">
                 <div class="block-header">
                     <div class="row clearfix">
                         <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">Resim 3MB den büyük olamaz.</div> </div> </div> </div> </div> </section>';
         } else {
    
             $yazi_dizisi = basename($_FILES["file"]["name"]);
    
             $target_filealt = str_replace(array('.png','.jpg','.jpeg', '.JPEG 2000' ,  '.xr', '.gif' , '.png' , '.apng','.tiff','.raw','.psd','.webp','.eps','.ai','.pdf','.svg', 'JPEG 2000' ,  'XR', 'GİF' , 'PNG' , 'APNG','TİFF','RAW','PSD','WEBP','EPS','Aİ','.mp4' ,'.MP4','PDF','SVG'),'',$yazi_dizisi); // Bu kod hem tire hem de alt tire karakterini siler.
    
    
             $tip = $_FILES['file']['type']; //resim tipini öğrendik.
             $resimAdi = $_FILES['file']['name']; //resmin adını öğrendik.
    
             $uzantisi = explode('.', $resimAdi); // uzantısını öğrenmek için . işaretinden parçaladık.
             $uzantisi = $uzantisi[count($uzantisi) - 1]; // ve daha sonra 1 den fazla nokta olma ihtimaline karşı en son noktadan sonrasını al dedik.
    
             $yeni_adidbdeki = "uploads/" . time() . "." . $uzantisi; // resime yeni isim vereceğimiz için zamana göre yeni bir isim oluşturduk ve yüklemesi gerektiği yeride belirttik.
             //yuklenecek_yer/resim_adi.uzantisi

             
             $yeni_adi = "../../uploads/" . time() . "." . $uzantisi; // resime yeni isim vereceğimiz için zamana göre yeni bir isim oluşturduk ve yüklemesi gerektiği yeride belirttik.
             //yuklenecek_yer/resim_adi.uzantisi
    
             if ($tip == 'image/jpeg' || $tip == 'image/png') { //uzantısnın kontrolünü sağladık. sadece .jpg ve .png yükleyebilmesi için.
    
             
                 if (move_uploaded_file($_FILES["file"]["tmp_name"], $yeni_adi)) {
                     //tmp_name ile resmi bulduk ve $yeni_adi değişkeninin değerine göre yükleme işlemini gerçekleştirdik.
    
    
                     $stmt = $conn->prepare("UPDATE hesapbilgileri SET image_name = :image_name, image_file = :image_file WHERE id = :id");
                     $stmt->bindParam(':image_name', $target_filealt);
                     $stmt->bindParam(':image_file', $yeni_adidbdeki);
                     $stmt->bindParam(':id', $id);
                     $stmt->execute();
    
    
                     echo '   <section class="content">
                     <div class="container-fluid">
                         <div class="block-header">
                             <div class="row clearfix">
                                 <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-success" style="text-align:center;" role="alert">Resim başarılı bir şekilde yüklendi. </div> </div> </div> </div> </div> </section>';
                 } 
             } else {
                 echo ' <section class="content">
                 <div class="container-fluid">
                     <div class="block-header">
                         <div class="row clearfix">
                             <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">Yanlızca JPG ve PNG resim gönderebilirsiniz. (Boş bırakılamaz)</div> </div> </div> </div> </div> </section>';
             }
         }
     }
    
    
    
    
    
    
    }
    


    
    if (@$_POST['backimage']) {

        if($cikti->uye_yetki == 0){$kullaniciid = $_SESSION["id"];}else{$kullaniciid = $hesap->firma_id;}

        $file = $_FILES["file"];
    
     if (empty($file) ) {
        echo '
        <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">
                     Fotoğraf Alanı boş bırakılamaz.
                    </div> </div> </div> </div> </div> </section>';
    
            
      }
    
     
     
     
     else {
         $resimBoyutubackimage = $_FILES['file']['size']; // resim boyutunu öğrendik
         if ($resimBoyutubackimage > (1024 * 1024 * 3)) {
             //buradaki işlem aslında bayt, kilobayt ve mb formülüdür.
             //2 rakamını mb olarak görün ve kaç yaparsanız o mb anlamına gelir.
             //Örn: (1024 * 1024 * 3) => 3MB / (1024 * 1024 * 4) => 4MB
    
             echo ' <section class="content">
             <div class="container-fluid">
                 <div class="block-header">
                     <div class="row clearfix">
                         <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">Resim 3MB den büyük olamaz.</div> </div> </div> </div> </div> </section>';
         } else {
    
            $yazi_dizisi = basename($_FILES["file"]["name"]);
    
            $target_filealt = str_replace(array('.png','.jpg','.jpeg', '.JPEG 2000' ,  '.xr', '.gif' , '.png' , '.apng','.tiff','.raw','.psd','.webp','.eps','.ai','.pdf','.svg', 'JPEG 2000' ,  'XR', 'GİF' , 'PNG' , 'APNG','TİFF','RAW','PSD','WEBP','EPS','Aİ','.mp4' ,'.MP4','PDF','SVG'),'',$yazi_dizisi); // Bu kod hem tire hem de alt tire karakterini siler.
    
    
            $tip = $_FILES['file']['type']; //resim tipini öğrendik.
            $resimAdi = $_FILES['file']['name']; //resmin adını öğrendik.
    
            $uzantisi = explode('.', $resimAdi); // uzantısını öğrenmek için . işaretinden parçaladık.
            $uzantisi = $uzantisi[count($uzantisi) - 1]; // ve daha sonra 1 den fazla nokta olma ihtimaline karşı en son noktadan sonrasını al dedik.
    
            
            $yeni_adidbdeki = "imagebackground/" . time() . "." . $uzantisi; // resime yeni isim vereceğimiz için zamana göre yeni bir isim oluşturduk ve yüklemesi gerektiği yeride belirttik.
            //yuklenecek_yer/resim_adi.uzantisi
            $yeni_adi = "../../imagebackground/" . time() . "." . $uzantisi; // resime yeni isim vereceğimiz için zamana göre yeni bir isim oluşturduk ve yüklemesi gerektiği yeride belirttik.
            //yuklenecek_yer/resim_adi.uzantisi
    
            if ($tip == 'image/jpeg' || $tip == 'image/png') { //uzantısnın kontrolünü sağladık. sadece .jpg ve .png yükleyebilmesi için.
    
            
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $yeni_adi)) {
                    //tmp_name ile resmi bulduk ve $yeni_adi değişkeninin değerine göre yükleme işlemini gerçekleştirdik.
    
                    $stmt = $conn->prepare("UPDATE frontbilgi SET backimage = :backimage WHERE firma_id = :firma_id");
                    $stmt->bindParam(':backimage', $yeni_adidbdeki); 
                    $stmt->bindParam(':firma_id', $kullaniciid);
                    $stmt->execute();
    
    
    
                    echo '   <section class="content">
                    <div class="container-fluid">
                        <div class="block-header">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-success" style="text-align:center;" role="alert">Resim başarılı bir şekilde yüklendi. </div> </div> </div> </div> </div> </section>';  } 
             } else {
                 echo ' <section class="content">
                 <div class="container-fluid">
                     <div class="block-header">
                         <div class="row clearfix">
                             <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">Yanlızca JPG ve PNG resim gönderebilirsiniz. (Boş bırakılamaz)</div> </div> </div> </div> </div> </section>';
             }
         }
     }
    
    
    
    }
    ?>
<?php 

if (@$_POST['slugurl']) {

    if($cikti->uye_yetki == 0){$slugid = $_SESSION["id"];}else{$slugid = $hesap->firma_id;}

    $slug = trim(filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING));

    // Check if the same slug already exists in the database
    $stmt = $conn->prepare("SELECT * FROM uyegiris WHERE slug = ?");
    $stmt->execute([$slug]);
    $existing_slug = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_slug && $existing_slug['id'] != $slugid) { // If the same slug exists and it's not for the current user
        echo '  <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12"> <div class="alert alert-danger" style="text-align:center;" role="alert">
                   Bu url kullanılmakta. Lütfen başka bir url giriniz.
                    </div> </div> </div> </div> </div> </section>';
    } else { // Otherwise, update the slug for the user
        $stmt = $conn->prepare("UPDATE uyegiris SET slug = ? WHERE id = ?");
        $stmt->execute([$slug, $slugid]);

        header("Refresh:0");
    }
}

?>

<!doctype html>
<html class="no-js " lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>Admin Paneli</title>
<link rel="icon" href="../../favicon.ico" type="image/x-icon">

<link rel="stylesheet" type="text/css" href="../../assets/fileuploaddoc/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../../assets/fileuploaddoc/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="../../assets/fileuploaddoc/css/component.css" />
<!-- Favicon-->
<link rel="stylesheet" href="../../assets/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/plugins/dropzone/dropzone.css">
<link rel="stylesheet" href="../../assets/plugins/bootstrap-select/css/bootstrap-select.css" />
<!-- Custom Css -->
<link rel="stylesheet" href="../../assets/css/main.css">
<link rel="stylesheet" href="../../assets/css/blog.css">
<link rel="stylesheet" href="../../assets/css/color_skins.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">


<script>(function(e,t,n){var r=e.querySelectorAll("php")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

</head>
<body class="theme-black">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="<?php echo $hesaplogosu ;?>" width="48" height="48" ></div>
        <p> Lütfen Bekleyin...</p>        
    </div>
</div>

<div class="overlay"></div><!-- Overlay For Sidebars -->

<!-- Left Sidebar -->
<aside id="minileftbar" class="minileftbar">
    <ul class="menu_list">
        <li>
            <a href="javascript:void(0);" class="bars"></a>
            <a style="background: #7c7979;" class="navbar-brand" href="../../index.php"><img src="<?php echo $hesaplogosu ;?>"></a>
        </li>
        <li><a href="javascript:void(0);" class="menu-sm"><i class="zmdi zmdi-swap"></i></a></li>        
        <li class="menuapp-btn"><a href="javascript:void(0);"><i class="zmdi zmdi-apps"></i></a></li>
      
      
        <li><a href="javascript:void(0);" class="fullscreen" data-provide="fullscreen"><i class="zmdi zmdi-fullscreen"></i></a></li>
        <li class="power">
            <a href="javascript:void(0);" class="js-right-sidebar"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a>       
            
  

<a href="../../cikis.php" onclick="return confirm('Çıkış yapmak istediğinize emin misiniz?')" class="mega-menu"><i class="zmdi zmdi-power"></i></a>
        </li>
    </ul>    
</aside>

<aside class="right_menu">
    <div class="menu-app">
        <div class="slim_scroll">
            <div class="card">
                <div class="header">
                    <h2><strong>Mobil</strong> Menü</h2>
                </div>
                <div class="body">
                    <ul class="list-unstyled menu">
                    <?php if($cikti->uye_yetki == 0){  ?>
                <li <?php if($urlcek == "" OR $urlcek == "adminsayfa=anasayfa" ){echo 'class="active open"';}; ?>> <a href="../../index.php"><i class="zmdi zmdi-home"></i><span>Anasayfa</span> </a> </li>
                <li <?php if($urlcek == "adminsayfa=hesap-ekle"){echo 'class="active open"';}; ?>  >  <a href="../../index.php?adminsayfa=hesap-ekle"><i class="zmdi zmdi-plus-circle"></i><span>Yeni Ekle</span> </a> </li>
                <li <?php if($urlcek == "adminsayfa=sm-hesap-ekle"){echo 'class="active open"';}; ?> ><a href="../../index.php?adminsayfa=sm-hesap-ekle"><i class="zmdi zmdi-label-alt"></i><span>Sosyal Medya Hesapları</span> </a> </li>                
                <li  <?php if($urlcek == "adminsayfa=hesaplar"){echo 'class="active open"';}; ?>><a href="../../index.php?adminsayfa=hesaplar"><i class="zmdi zmdi-sort-amount-desc"></i><span>Haber Listesi</span> </a> </li>
                <?php }?>

              
              <?php if($cikti->uye_yetki == 1){  ?>
                <li  <?php if($urlcek == "adminsayfa=anasayfa-admin"){echo 'class="active open"';}; ?>><a href="../../index.php?adminsayfa=anasayfa-admin"><i class="fas fa-users"></i><span>Kullanıcılar</span> </a> </li>
                <li  <?php if($urlcek == "adminsayfa=hesap-olustur"){echo 'class="active open"';}; ?>><a href="../../index.php?adminsayfa=hesap-olustur"><i class="fas fa-users"></i><span>Hesap Oluştur</span> </a> </li>

                <?php }?>    
            </ul>
                </div>
            </div>
        </div>
    </div>

   
    <div id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#setting">Ayarlar</a></li>        
        </ul>
        <div class="tab-content slim_scroll">
            <div class="tab-pane slideRight active" id="setting">
            <div class="card" bis_skin_checked="1">
                    <div class="header" bis_skin_checked="1">
                        <h2><strong>Site</strong> Url</h2>
                    </div>
                    <div class="body theme-light-dark" bis_skin_checked="1">
                        <form action="" method="post">
                            <label> Url </label>
                        <input type="text" class="form-control" name="slug" value="<?php echo $cikti->slug;?>"><br>
                        <input type="submit" name="slugurl" class="t-dark btn btn-primary btn-round btn-block">
                        </form>
                    </div>
                </div>
                
                <div class="card" bis_skin_checked="1">
                    <div class="header" bis_skin_checked="1">
                        <h2><strong>Site</strong> Arkaplan Fotoğrafı</h2>
                    </div>
                    <div class="body theme-light-dark" bis_skin_checked="1">
                        <form action="" method="post"  enctype='multipart/form-data'>
                        <div class="wrapperimgback">
  <div class="file-uploadimgback">
    <input type="file" name="file"/>
    <i class="fa fa-arrow-up"></i>
  </div>
</div>
   
                        <input type="submit" name="backimage" class="t-dark btn btn-primary btn-round btn-block"  value="Kaydet" >
                        </form>
                    </div>
                </div>


                <div class="card">
                    <div class="header">
                        <h2><strong>Site </strong> Rengi</h2>
                    </div>
                    <div class="body">
                        <ul class="choose-skin list-unstyled m-b-0">
                            <li data-theme="black" class="active">
                                <div class="black"></div>
                            </li>
                            <li data-theme="purple">
                                <div class="purple"></div>
                            </li>                   
                            <li data-theme="blue">
                                <div class="blue"></div>
                            </li>
                            <li data-theme="cyan">
                                <div class="cyan"></div>                    
                            </li>
                            <li data-theme="green">
                                <div class="green"></div>
                            </li>
                            <li data-theme="orange">
                                <div class="orange"></div>
                            </li>
                            <li data-theme="blush">
                                <div class="blush"></div>                    
                            </li>
                        </ul>
                    </div>
                </div>                
            
                <div class="card">
                    <div class="header">
                        <h2><strong>Sol </strong> Menü</h2>
                    </div>
                    <div class="body theme-light-dark">
                        <button class="t-dark btn btn-primary btn-round btn-block">Karanlık Mod</button>
                    </div>
                </div>               
            </div>
            <div class="tab-pane slideLeft" id="activity">
                <div class="card activities">
                    
                    <div class="body">
                        <div class="streamline b-accent">
                            <div class="sl-item">
                                <div class="sl-content">
                                    <div class="text-muted">Just now</div>
                                    <p>Finished task <a href="" class="text-info">#features 4</a>.</p>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="leftsidebar" class="sidebar">
        <div class="menu">
        <ul class="list">
                <li>
                    
   


                    <div class="user-info m-b-20">
                        <div class="image">
                            <a href="../../index.php"><img src="<?php echo $hesaplogosu ;?>" alt="User"></a>
                        </div>
                        <div class="detail">
                        <h6><?php if(@$frontbilgi->baslik == NULL){$uyebaslik = "Admin";}else{$uyebaslik = $frontbilgi->baslik; } echo $uyebaslik; ?></h6>   
                               
                        </div>
                    </div>
                </li>
                <li class="header">Sayfalar</li>
                <?php if($cikti->uye_yetki == 0){  ?>
                <li <?php if($urlcek == "" OR $urlcek == "adminsayfa=anasayfa" ){echo 'class="active open"';}; ?>> <a href="../../index.php"><i class="zmdi zmdi-home"></i><span>Anasayfa</span> </a> </li>
                <li <?php if($urlcek == "adminsayfa=hesap-ekle"){echo 'class="active open"';}; ?>  >  <a href="../../index.php?adminsayfa=hesap-ekle"><i class="zmdi zmdi-plus-circle"></i><span>Yeni Ekle</span> </a> </li>
                <li <?php if($urlcek == "adminsayfa=sm-hesap-ekle"){echo 'class="active open"';}; ?> ><a href="../../index.php?adminsayfa=sm-hesap-ekle"><i class="zmdi zmdi-label-alt"></i><span>Sosyal Medya Hesapları</span> </a> </li>                
                <li  <?php if($urlcek == "adminsayfa=hesaplar"){echo 'class="active open"';}; ?>><a href="../../index.php?adminsayfa=hesaplar"><i class="zmdi zmdi-sort-amount-desc"></i><span>Haber Listesi</span> </a> </li>
                <?php }?>

              
              <?php if($cikti->uye_yetki == 1){  ?>
                <li  <?php if($urlcek == "adminsayfa=anasayfa-admin"){echo 'class="active open"';}; ?>><a href="../../index.php?adminsayfa=anasayfa-admin"><i class="fas fa-users"></i><span>Kullanıcılar</span> </a> </li>
                <li  <?php if($urlcek == "adminsayfa=hesap-olustur"){echo 'class="active open"';}; ?>><a href="../../index.php?adminsayfa=hesap-olustur"><i class="fas fa-users"></i><span>Hesap Oluştur</span> </a> </li>

                <?php }?>
            </ul>
            </ul>
        </div>
    </div>
</aside>










<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Haber Düzenleme  </h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Haber Düzenle</li>
                    </ul>
                </div>            
                <div class="col-lg-7 col-md-7 col-sm-12">
        
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                 
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>İd</th>
                                    <th>Haber Adı</th>
                                    <th>Fotoğraf İsmi (alt="")</th>
                                    <th>Haber Url</th>
                                </tr>
                            </thead>
                            <form action="" method="post">

                            <tbody>
                                <tr>
                                    <th scope="row"><?php echo $hesap->id;?></th>
                                    <td> <div class="form-group"><input class="form-control" type="text" name="hesapadi" required value="<?php echo $hesap->hesapadi;?>"></div> </td>
                                    <td> <div class="form-group"><input class="form-control" type="text" name="image_name" required value="<?php echo $hesap->image_name;?>"></div> </td>
                                    <td> <div class="form-group"><input class="form-control" type="text" name="hesapurl" required value="<?php echo $hesap->hesapurl;?>"></div> </td>
                                </tr>
                            </tbody>
                           

                        </table>
                        <input style="width:100%" type="submit" class="btn btn-primary btn-round waves-effect m-t-20" value="Bilgileri Güncelle" name="bilgidegis">

</form>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- #END# Hover Rows --> 
    </div>


    <style>


    </style>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="body"  style="background-color:#d9d9d9;">
<form action="" method="post" enctype="multipart/form-data"  > 
<h2  class="h2upload">Dosya Yükleme ve Görüntü Önizleme</h2>
<br>
<!-- Upload  -->
<div id="file-upload-form" class="uploader">
  <input id="file-upload" type="file" name="file" accept="image/*" />

  <label for="file-upload" id="file-drag">
    <img id="file-image" src="#" alt="Preview" class="hidden">
    <div id="start">
      <i class="fa fa-download" aria-hidden="true"></i>
      <div>Dosya yüklemek için seçim yapnız </div>
      <div id="notimage" class="hidden">Lütfen fotoğraf seçiniz.</div>
      <span id="file-upload-btn" class="btn btn-primary">Fotoğraf Seç</span>
    </div>
    <div id="response" class="hidden">
      <div id="messages"></div>
      <progress class="progress" id="file-progress" value="0">
        <span>0</span>%
      </progress>
    </div>
  </label>
</div>

<input style="width:100%" type="submit" class="btn btn-primary btn-round waves-effect m-t-20" name="fotodegis" value="Fotoğrafı Güncele" >
</form>
</div>
</div></div>
</section>






<script src="../../assets/fileuploaddoc/js/custom-file-input.js"></script>

<script src="../../assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
<script src="../../assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 

<script src="../../assets/plugins/dropzone/dropzone.js"></script> <!-- Dropzone Plugin Js --> 

<script src="../../assets/plugins/ckeditor/ckeditor.js"></script> <!-- Ckeditor -->

<script src="../../assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
<script src="../../assets/js/pages/forms/editors.js"></script>
<script src="../../assets/js/upload.js"></script>

</body>
</html>
 <?php  } else{echo"ERİŞİM YASAK";}  ?>
 