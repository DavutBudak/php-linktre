

<?php
 include("../../admin_init.php");

 $id = intval($_GET["id"]);
 $uyeid = intval($_GET["uyeid"]);
$firma_id_head = $_SESSION["id"];
 


 $sorgu = $conn->prepare('SELECT * FROM uyegiris WHERE id = :firma_id');
 $sorgu->bindParam(':firma_id', $firma_id_head, PDO::PARAM_INT);
 $sorgu->execute();
 $cikti = $sorgu->fetch(PDO::FETCH_OBJ);
 


$firma_id = $_SESSION["id"];
$hesaplar = $conn->prepare("SELECT * FROM smhesapbilgileri WHERE id = ?");
$hesaplar->execute(array($id));
    $hesap = $hesaplar->fetch(PDO::FETCH_OBJ);


// Frontbilgi tablosundan firma_id'si 1 olan veriyi sorgulama
$stmt = $conn->prepare("SELECT * FROM frontbilgi WHERE firma_id=:firma_id");
$stmt->bindParam(':firma_id', $firma_id_head);
$stmt->execute();
$frontbilgi = $stmt->fetch(PDO::FETCH_OBJ);


$url = 'https://'.$_SERVER['SERVER_NAME'];
$urlcek = $_SERVER['QUERY_STRING'];  





if(@$hesap->firma_id == $firma_id OR $cikti->uye_yetki == 1 ) { 

 
    
    $firmalar = $conn->prepare("SELECT * FROM smhesapbilgileri WHERE id = ?");
 $firmalar->execute(array($id));
 if ($firmalar) {
     $firma = $firmalar->fetch(PDO::FETCH_OBJ);
 }




 $firma_duzenle = $conn->prepare("UPDATE smhesapbilgileri SET smhesapdurum = ? WHERE id = ? ");
 $firma_duzenle->execute(array(0, $id));
  
   
  
  if ($firma_duzenle) {
        echo '
                     <div class="alert alert-success" style="text-align:center;" role="alert">
                     Değişiklikler kayıt edildi. Listeye yönlendirilecek.
                     </div>';
                     if( $uyeid == NULL){        header("Location:../../index.php?adminsayfa=sm-hesap-ekle");
                     }else{header("Location: uye_hesap_duzenle.php?id=$uyeid");
                     }
                    } else {
        echo '
                     <div class="alert alert-danger" style="text-align:center;" role="alert">
                      güncelleme başarısız. Bir sorun oluştu.
                     </div>';
                     if( $uyeid == NULL){        header("Location:../../index.php?adminsayfa=sm-hesap-ekle");
                     }else{header("Location: uye_hesap_duzenle.php?id=$uyeid");
                     }

      }      }
else {  ECHO "ERİŞİM YASAK";
}   
  

            ?>