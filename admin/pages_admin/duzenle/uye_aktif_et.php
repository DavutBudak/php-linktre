
<?php
 include("../../admin_init.php");

 $id = intval($_GET["id"]);
 

 @$firma_id_head = $_SESSION["id"];
                
 


                $sorgu = $conn->prepare('SELECT * FROM uyegiris WHERE id = :firma_id');
                $sorgu->bindParam(':firma_id', $firma_id_head, PDO::PARAM_INT);
                $sorgu->execute();
                $cikti = $sorgu->fetch(PDO::FETCH_OBJ);
                
               
               
               


                if($cikti->uye_yetki == 1 ) { 

 $uye = $conn->prepare("SELECT * FROM uyegiris WHERE id = ?");
 $uye->execute(array($id));
 if ($uye) {
     $firma = $uye->fetch(PDO::FETCH_OBJ);
 }





      $uye_duzenle = $conn->prepare("UPDATE uyegiris SET uye_hesap_durum = ? WHERE id = ? ");
  $uye_duzenle->execute(array(0, $id));
   
  
  if ($uye_duzenle) {
        echo '
                     <div class="alert alert-success" style="text-align:center;" role="alert">
                     Değişiklikler kayıt edildi. Listeye yönlendirilecek.
                     </div>';
                     
        header("Location:../../index.php?adminsayfa=anasayfa-admin");
      } else {
        echo '
                     <div class="alert alert-danger" style="text-align:center;" role="alert">
                      güncelleme başarısız. Bir sorun oluştu.
                     </div>';
                     header("Location:../../index.php?adminsayfa=anasayfa-admin");

      }
    }
    else {  ECHO "ERİŞİM YASAK";
    }   
  

            ?>