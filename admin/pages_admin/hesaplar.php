<?php
if($cikti->uye_yetki == 1){

    header("Location:index.php?adminsayfa=anasayfa-admin");

 }else{
    $firma_id = $_SESSION["id"];



    $stmtfull = $conn->prepare("SELECT COUNT(id) as id_count FROM hesapbilgileri WHERE firma_id = :firma_id");
$stmtfull->bindParam(':firma_id', $firma_id, PDO::PARAM_INT);
$stmtfull->execute();
    $result = $stmtfull->fetch(PDO::FETCH_ASSOC);

    $stmtaktif = $conn->prepare("SELECT COUNT(id) as id_count FROM hesapbilgileri WHERE hesapdurum = 1 AND firma_id = :firma_id");
    $stmtaktif->bindParam(':firma_id', $firma_id, PDO::PARAM_INT);
    $stmtaktif->execute();
    $resultaktif = $stmtaktif->fetch(PDO::FETCH_ASSOC);


    $stmtpasif = $conn->prepare("SELECT COUNT(id) as id_count FROM hesapbilgileri WHERE hesapdurum = 0 AND firma_id = :firma_id");
    $stmtpasif->bindParam(':firma_id', $firma_id, PDO::PARAM_INT);
    $stmtpasif->execute();
    $resultpasif = $stmtpasif->fetch(PDO::FETCH_ASSOC);


    ?>
<section class="content blog-page">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Tüm Haberler</h2>
                    <ul class="breadcrumb p-l-0 p-b-0">
                        <li class="breadcrumb-item"><a href="index.php"><i class="zmdi zmdi-home"></i></a></li>
                        <li  class="breadcrumb-item active">Haberler</li>
                    </ul>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12">
                  
                </div>
            </div>
        </div>
        <div class="row clearfix" style="text-align:center">
            <div class="col-lg-4 col-md-4">
                <div class="card">
                    <div class="body" >
                        <h4 class="m-t-0 m-b-0"><?php echo   $result['id_count'];?></h4>
                        <p class="m-b-0">Toplam Haber</p>                    
                 
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card">
                    <div class="body">
                        <h4 class="m-t-0 m-b-0"><?php echo   $resultaktif['id_count'];?></h4>
                        <p class="m-b-0 ">Aktif Haber</p>
                       
                    </div>
                </div>
            </div>
      

            <div class="col-lg-4 col-md-4">
                <div class="card">
                    <div class="body">
                        <h4 class="m-t-0 m-b-0"><?php echo   $resultpasif['id_count'];?></h4>
                        <p class="m-b-0 ">Pasif Haber</p>
                       
                    </div>
                </div>
            </div>
      
     
        </div>
        
               
   
                
        <div class="row clearfix">
            <div class="col-md-12">
                    <div class="card">
                    <div class="header">
                        <h2><strong>Haberler</h2>
                 
                    </div>
                    <div class="body">
                        <div class="table-responsive social_media_table">
                            <table class="table table-hover" style="width:100%; text-align:center;">
                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Haber Adı</th>
                                        <th>Haber Url</th>                                                                                
                                        <th>Haber Durumu</th>
                                        <th>Düzenle / Sil <br> Aktif / Pasif</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
        $bilgiler = $conn->prepare("SELECT * FROM hesapbilgileri WHERE firma_id = :firma_id ORDER BY id DESC");
        $bilgiler->bindParam(':firma_id', $firma_id, PDO::PARAM_INT);
        $bilgiler->execute();
            $bilgisonuc=$bilgiler->fetchAll();
            foreach ($bilgisonuc as $bilgi) {
                if($bilgi['hesapdurum'] == 0) {$durumrenk = "color:red;";} else{ $durumrenk = "color:green;";}
                ?>
                                    <tr>
                                        <td><span class="social_icon"> <img src="<?php echo $url;?>/linktre/admin/<?php echo $bilgi['image_file']; ?>" alt=""> </span>
                                        </td>
                                        <td><span class="list-name"><?php echo $bilgi['hesapadi']; ?></span>
                                        </td>
                                        <td><?php echo $bilgi['hesapurl']; ?></td>
                                        <td> <b style="<?php echo $durumrenk; ?>"> <?php if($bilgi['hesapdurum'] == 0) {echo "Pasif";} else{ echo "Aktif";}  ?> </b>  </td>
                                        <td>
                                            
                                        <div class="form-group col-12" > 
                    <a class="btn" style="text-align:center !important; width:50%;" onclick="return confirm('Veri Aktif Edilecek Onaylıyormusunuz')" href="pages_admin/duzenle/hesap_aktif.php?id=<?php echo $bilgi['id']?>" class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i> Aktif Et</a>
                    <a class="btn"  style="text-align:center !important; width:50%;"onclick="return confirm('Veri Pasif Edilecek Onaylıyormusunuz')" href="pages_admin/duzenle/hesap_pasif.php?id=<?php echo $bilgi['id']?>" class="btn_1 gray delete"><i class="fa fa-fw fa-times-circle-o"></i> Pasif Et</a>
            </div> 
                                        <div class="form-group col-12" >
                                       <a class="btn" style="text-align:center !important; width:50%;" href="pages_admin/duzenle/hesap_duzenle.php?id=<?php echo $bilgi['id']?>" class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i> Düzenle</a>
 
                    <a  class="btn"  style="text-align:center !important; width:50%;" onclick="return confirm('Veri silinecek Onaylıyormusunuz')" href="pages_admin/duzenle/hesapsil.php?id=<?php echo $bilgi['id']?>" class="btn_1 gray delete"><i class="fa fa-fw fa-times-circle-o"></i> Sil</a>
            </div></td>


                                    
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
       
                   
                </div>                
            </div>
        </div>
    </div>   
</section>
<?php }?>
