
<?php
 include("../../admin_init.php");

                

                @$id = intval($_GET["id"]);
               @$firma_id_head = $_SESSION["id"];
                
 


                $sorgu = $conn->prepare('SELECT * FROM uyegiris WHERE id = :firma_id');
                $sorgu->bindParam(':firma_id', $firma_id_head, PDO::PARAM_INT);
                $sorgu->execute();
                $cikti = $sorgu->fetch(PDO::FETCH_OBJ);
                
               
               
               


                if($cikti->uye_yetki == 1 ) { 

            $firma_getir = $conn->prepare("SELECT * FROM uyegiris WHERE id = ?");
            $firma_getir->execute(array($id));
            if ($firma_getir->rowCount()) {

                $firma_sil = $conn->prepare("DELETE FROM uyegiris WHERE id = ?");
                $firma_sil->execute(array($id));
                if ($firma_sil->rowCount()) {
                    echo '
                    <div class="alert alert-success" style="text-align:center;" role="alert">
                    Hesap silindi.
                    </div>';
                    header("Location:../../index.php?adminsayfa=anasayfa-admin");
                                  } else {
                    echo '    
                    <div class="alert alert-danger" style="text-align:center;" role="alert">
                    Hesap silme başarısız. Bir sorun oluştu.
                    </div>';
                }

            } else {
               
                header("Location:../../index.php?adminsayfa=anasayfa-admin");
                         }}
                else {  ECHO "ERİŞİM YASAK";
                }   
                  


            ?>
    