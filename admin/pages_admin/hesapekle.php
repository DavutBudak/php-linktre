<?php
if($cikti->uye_yetki == 1){

    header("Location:index.php?adminsayfa=anasayfa-admin");
 }else{
if (@$_POST['fotodegis']) {

    $id = $_SESSION["id"];

    $hesapadi = trim(filter_input(INPUT_POST, 'hesapadi', FILTER_SANITIZE_STRING));
    $hesapurl = trim(filter_input(INPUT_POST, 'hesapurl', FILTER_SANITIZE_STRING));
    $file = $_FILES["file"];




 if (empty($hesapadi) || empty($hesapurl)|| empty($file) ) {
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


                 $stmt = $conn->prepare("INSERT INTO hesapbilgileri (firma_id,image_name, image_file, hesapadi, hesapurl)   
                 VALUES (:firma_id, :image_name, :image_file, :hesapadi, :hesapurl)");
                
                $stmt->bindParam(':firma_id', $id);
                $stmt->bindParam(':image_name', $target_filealt);
                 $stmt->bindParam(':image_file', $yeni_adi); 
                 $stmt->bindParam(':hesapadi', $hesapadi);
                 $stmt->bindParam(':hesapurl', $hesapurl);
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




<section class="content blog-page">
<div class="container-fluid">
 <div class="block-header">
     <div class="row">
         <div class="col-lg-5 col-md-5 col-sm-12">
             <h2>Yeni Hesap Ekle</h2>
             <ul class="breadcrumb p-l-0 p-b-0">
                 <li class="breadcrumb-item"><a href="index.php"><i class="zmdi zmdi-home"></i></a></li>
                 <li class="breadcrumb-item active">Yeni Hesap</li>
             </ul>
         </div>
         <div class="col-lg-7 col-md-7 col-sm-12">
            
         </div>
     </div>
 </div>
 <div class="row">
     <div class="col-lg-12">
         <div class="card">
             <div class="body">
                 <div class="form-group">
                        <h2> Yeni Hesap Ekle </h2>
             </div>
            
        


             <div class="content">

<form action="" method="post"   enctype='multipart/form-data'>

<div class="row clearfix">
                     <div class="col-sm-6">
                         <div class="form-group">                                 
                             <input type="text" class="form-control" name="hesapadi" placeholder="Hesap Adı" >
                         </div>
                         </div>

                         <div class="col-sm-6">

                         <div class="form-group">                                    
                             <input type="text" class="form-control" name="hesapurl" placeholder="Hesap Url" >
                         </div>                         </div>

                  
                     </div>
                 </div>
                 <div style="margin-top:30px;" class="col-lg-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="body" style="background-color:#d9d9d9;">
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
<br><br>


</form>
</div>
</div></div>
         </div>
   
     </div>          
     
     
 </div>
</div>


</section>

<script>
    
</script>
<!-- Jquery Core Js -->    
 <?php }?>
