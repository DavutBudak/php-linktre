
<?php
if($cikti->uye_yetki == 1){
 
    header("Location:index.php?adminsayfa=anasayfa-admin");
 }else{
    $firma_id = $_SESSION["id"];

if (@$_POST['smhesapurl']) {
    $id = $_POST['id'];
    $smhesapurl = trim(filter_input(INPUT_POST, 'smhesapurl', FILTER_SANITIZE_STRING));
    $smhesapicon = trim(filter_input(INPUT_POST, 'smhesapicon', FILTER_SANITIZE_STRING));

    
    for ($i = 0; $i < count($id); $i++) {
        $sql = "UPDATE smhesapbilgileri SET smhesapurl = ? , smhesapicon = ?   WHERE id = ?";
        $stmt= $conn->prepare($sql);
        $stmt->execute([$smhesapurl[$i], $smhesapicon[$i], $id[$i]]);
    } 

} ?>
<style> 
    td .form-group input::placeholder{color:#313740 !important; font-weight:bold !important;} 
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control { font-weight:bold !important; background-color: #E3E3E3;  color: black; cursor: not-allowed;}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Sosyal Medya Hesapı Ekle</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index.php"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Sosyal Medya Hesapları</li>
                    </ul>
                </div>            
                <div class="col-lg-7 col-md-7 col-sm-12">
              
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Hesap İcon Ekleme</strong><small>Font Awesome nin sitesinden Fontaweome 5 sürümündeki iconları kullanabilirsiniz. <strong style="color:blue;"> Url = </strong> &nbsp; <a style="color:red;" target="_blank" href="https://fontawesome.com/v5/search?o=r&m=free">FontAwesome V5</a> </small> </h2>
                     
                    </div>
                    <div class="body">
                        <div class="row">
                         
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <table class="table table-bordered" id="editableTable">
                                <thead>
                                <tr>
                                    <th>Hesap Adı</th>
                                    <th>Hesap Url</th>
                                    <th>Hesap icon</th>
                                    <th>Hesap Durum</th>
                                    <th>Aktif / Pasif </th>
                                </tr>
                                </thead>
                                <form action="" method="post">
        <tbody>
            <?php 
            $bilgiler = $conn -> prepare("SELECT * FROM smhesapbilgileri WHERE firma_id = ?  ORDER BY id ASC");
            $bilgiler->execute(array($firma_id));
            $bilgisonuc=$bilgiler->fetchAll();
            foreach ($bilgisonuc as $bilgi) {
                if($bilgi['smhesapdurum'] == 0) {$durumrenk = "bg-danger";} else{ $durumrenk = "bg-success";}
                ?>
                <tr>
                    <td>
                        <input type="hidden" name="id[]" value="<?php echo $bilgi['id']; ?>">
                        <div class="form-group">   <input data-value id="myInput" class="form-control" type="text" name="smhesapadi[]" value="<?php echo $bilgi['smhesapadi']; ?>" disabled> </div>
                    </td>
                    <td>
                    <div class="form-group">     <input class="form-control" type="text" name="smhesapurl[]" value="<?php echo $bilgi['smhesapurl']; ?>"></div>
                    </td>
                    <td>
                    <div class="form-group">     <input class="form-control" type="text" name="smhesapicon[]" value="<?php echo $bilgi['smhesapicon']; ?>"></div>
                    </td>
                    <td>
                    <div class="form-group">      <input class="form-control <?php echo $durumrenk; ?>" type="text"  value="<?php if($bilgi['smhesapdurum'] == 0) {echo "Pasif";} else{ echo "Aktif";}  ?>" disabled style="text-align:center;"></div>
                    </td>
                    <td> <div class="form-group" style="width:100%; text-align:center;  "> 
                    <a class="btn" style="text-align:center !important;" onclick="return confirm('Veri Aktif Edilecek Onaylıyormusunuz')" href="pages_admin/duzenle/smhesap_aktif.php?id=<?php echo $bilgi['id']?>" class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i> Aktif Et</a>
                    <a class="btn"  style="text-align:center !important;"onclick="return confirm('Veri Pasif Edilecek Onaylıyormusunuz')" href="pages_admin/duzenle/smhesap_pasif.php?id=<?php echo $bilgi['id']?>" class="btn_1 gray delete"><i class="fa fa-fw fa-times-circle-o"></i> Pasif Et</a>
            </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="form-group"  >
    <button type="submit" style="width:100% ;" class="btn btn-primary btn-round waves-effect m-t-20" name="smhesapkaydet">Kaydet</button> </div>
</form>
                            </div>
                            <?php

?>
                        </div>
                    </div>
                </div>
            </div>
 

        </div>
    </div>
</section>  


<?php } ?>