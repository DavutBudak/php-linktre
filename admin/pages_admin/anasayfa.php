<?php
if($cikti->uye_yetki == 1){

    header("Location:index.php?adminsayfa=anasayfa-admin");

 }else{
$idanasayfa = $_SESSION["id"];
$ayarlar = $conn->prepare("SELECT * FROM frontbilgi WHERE firma_id = ?");
$ayarlar->execute(array($idanasayfa));
if ($ayarlar) {
    $ayar = $ayarlar->fetch(PDO::FETCH_OBJ);
}?>
<?php
if (@$_POST['bilgi']) {

    $id = $_SESSION["id"];


    $etiket = trim(filter_input(INPUT_POST, 'etiket', FILTER_SANITIZE_STRING));
    $baslik = trim(filter_input(INPUT_POST, 'baslik', FILTER_SANITIZE_STRING));
    $hastag = trim(filter_input(INPUT_POST, 'hastag', FILTER_SANITIZE_STRING));
    $logourl = trim(filter_input(INPUT_POST, 'logourl', FILTER_SANITIZE_STRING));
    $logokaydet = "";
   
// Check if there is already a record with the given firma_id
$check_query = $conn->prepare("SELECT COUNT(*) as count FROM frontbilgi WHERE firma_id = ?");
$check_query->execute(array($id));
$result = $check_query->fetch(PDO::FETCH_ASSOC);

if ($result['count'] > 0) {
  // If there is a record, update it
  $firma_duzenle = $conn->prepare("UPDATE frontbilgi SET etiket = ? , baslik = ? , hastag = ? , logourl = ? WHERE firma_id = ? ");
  $firma_duzenle->execute(array($etiket, $baslik, $hastag, $logourl, $id));
} else {
  // If there is no record, insert a new one
  $firma_ekle = $conn->prepare("INSERT INTO frontbilgi (firma_id, etiket, baslik, hastag, logourl, logo) VALUES (?, ?, ?, ?, ?,?)");
  $firma_ekle->execute(array($id, $etiket, $baslik, $hastag, $logourl, $logokaydet));
}

if ($firma_duzenle || $firma_ekle) {
  echo '<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="alert alert-success"  style="text-align:center;"  role="alert">
                        Değişiklikler kayıt edildi. Listeye yönlendirilecek.
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </section>';
  header("Location:index.php?adminsayfa=anasayfa");
}
}



if (@$_POST['fotodegis']) {
    $id = $_SESSION["id"];
@$file = $_FILES['file'];
    
    
    
    
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
    
             $yeni_adi = "uploads/" . time() . "." . $uzantisi; // resime yeni isim vereceğimiz için zamana göre yeni bir isim oluşturduk ve yüklemesi gerektiği yeride belirttik.
             //yuklenecek_yer/resim_adi.uzantisi

             
     
             if ($tip == 'image/jpeg' || $tip == 'image/png') { //uzantısnın kontrolünü sağladık. sadece .jpg ve .png yükleyebilmesi için.
    
             
                 if (move_uploaded_file($_FILES["file"]["tmp_name"], $yeni_adi)) {
                     //tmp_name ile resmi bulduk ve $yeni_adi değişkeninin değerine göre yükleme işlemini gerçekleştirdik.
    
    
                     $stmt = $conn->prepare("UPDATE frontbilgi SET logo = :logo WHERE firma_id = :firma_id");
                     $stmt->bindParam(':logo', $yeni_adi);
                     $stmt->bindParam(':firma_id', $id);
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
    
    

?>


<section class="content">    
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Anasayfa İçeriği </h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index.php"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Anasayfa</li>
                    </ul>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12">
              
                </div>
            </div>
        </div>
        <!-- Input -->
        <form action="" method="post"  > 

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Anasayfa </strong> <small>İçeriklerini Düzenle</small> </h2>                        
                    </div>

                    <div class="body">
                        
                        <h2 class="card-inside-title">Etiket & Başlık İçeriği</h2>
                        <div class="row ">
                            <div class="col-sm-6">
                                <div class="form-group">                                    
                                    <input name="etiket" type="text" class="form-control" required placeholder="ETİKET" value="<?php echo $ayar->etiket;?>" />                                   
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">                                   
                                    <input  name="baslik" type="text" class="form-control" required placeholder="BAŞLIK" value="<?php echo $ayar->baslik;?>" />                                    
                                </div>
                            </div>
                        </div>
                        <h2 class="card-inside-title">Hashtag & Logo Url</h2>
                        <div class="row ">
                            <div class="col-sm-6">
                                <div class="form-group">                                    
                                    <input name="hastag" type="text" class="form-control" required placeholder="HASTHAG" value="<?php echo $ayar->hastag;?>" />                                   
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">                                   
                                    <input  name="logourl" type="text" class="form-control"required placeholder="LOGO URL" value="<?php echo $ayar->logourl;?>" />                                    
                                </div>
                            </div>

                        </div>   
                        
          
                        
                         <input style="width:100%" type="submit" class="btn btn-primary btn-round waves-effect m-t-20" name="bilgi" value="Bilgileri Güncele" >
</form>
                     
                     
                        <h2 class="card-inside-title">Logo </h2>
                        <div class="row ">
                        <div class="col-sm-12">
                                <div class="form-group">  
                                <div class="card">
        <div class="body" style="background-color:#d9d9d9;">
<h2  class="h2upload">Dosya Yükleme ve Görüntü Önizleme</h2>
<br>
<!-- Upload  -->
<form action="" method="post" enctype="multipart/form-data"  > 

<div id="file-upload-form" class="uploader">
  <input  required id="file-upload" type="file" name="file" accept="image/*" />

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
<br><br>


</div>
</div></div>
</form>
                         </div>
                </div>
            </div>
        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Input --> 
        <!-- Textarea -->
        
    </div>
</section>
<?php } ?>