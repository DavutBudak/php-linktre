
<?php
 include("../../admin_init.php");

                

                @$id = intval($_GET["id"]);
                @$uyeid = intval($_GET["uyeid"]);
               @$firma_id_head = $_SESSION["id"];
                
 


                $sorgu = $conn->prepare('SELECT * FROM uyegiris WHERE id = :firma_id');
                $sorgu->bindParam(':firma_id', $firma_id_head, PDO::PARAM_INT);
                $sorgu->execute();
                $cikti = $sorgu->fetch(PDO::FETCH_OBJ);
                
               
               
               $firma_id = $_SESSION["id"];
               $hesaplar = $conn->prepare("SELECT * FROM hesapbilgileri WHERE id = ?");
               $hesaplar->execute(array($id));
                   $hesap = $hesaplar->fetch(PDO::FETCH_OBJ);
               
               


                if(@$hesap->firma_id == $firma_id OR $cikti->uye_yetki == 1 ) { 

            $firma_getir = $conn->prepare("SELECT * FROM hesapbilgileri WHERE id = ?");
            $firma_getir->execute(array($id));
            if ($firma_getir->rowCount()) {

                $firma_sil = $conn->prepare("DELETE FROM hesapbilgileri WHERE id = ?");
                $firma_sil->execute(array($id));
                if ($firma_sil->rowCount()) {
                    echo '
                    <div class="alert alert-success" style="text-align:center;" role="alert">
                    Hesap silindi.
                    </div>';
                    if( $uyeid == NULL){        header("Location:../../index.php?adminsayfa=hesaplar");
                    }else{header("Location: uye_hesap_duzenle.php?id=$uyeid");
                    }                } else {
                    echo '    
                    <div class="alert alert-danger" style="text-align:center;" role="alert">
                    Hesap silme başarısız. Bir sorun oluştu.
                    </div>';
                }

            } else {
                if( $uyeid == NULL){        header("Location:../../index.php?adminsayfa=hesaplar");
                }else{header("Location: uye_hesap_duzenle.php?id=$uyeid");
                }            }}
                else {  ECHO "ERİŞİM YASAK";
                }   
                  


            ?>
    