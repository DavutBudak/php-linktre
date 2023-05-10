<?php 
if($cikti->uye_yetki == 0){

    header("Location:index.php");
 }else{?>
 <section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Kullanıcı Listesi</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">Kullanıcılar</li>
                    </ul>
                </div>            
                <div class="col-lg-7 col-md-7 col-sm-12">
    
                </div>
            </div>
        </div>
        <style>#DataTables_Table_0_filter label{float: right !important;}.dataTables_info{display:none;}</style>

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Kullanıcı</strong> Tablosu </h2>
              
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable"  style="text-align:center;">
                            <thead >
                                <tr>
                                    <th>İd</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>Şifre</th>
                                    <th>Slug</th>
                                    <th>Yetki</th>
                                    <th>Hesap Durum</th>
                                    <th>Düzenle / Sil / Aktif / Pasif</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>İd</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>Şifre</th>
                                    <th>Slug</th>
                                    <th>Yetki</th>
                                    <th>Hesap Durum</th>
                                    <th>Düzenle / Sil / Aktif / Pasif</th>
                                </tr>
                            </tfoot>
                            <tbody>

                            <?php     // Sorgu hazırlama
    $stmt = $conn->prepare("SELECT * FROM uyegiris");

    // Sorguyu çalıştırma
    $stmt->execute();

    // Sonuçları alma
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Sonuçları ekrana yazdırma
    foreach ($results as $bilgiler) {if($bilgiler["uye_yetki"] != 1){
        if($bilgiler['uye_hesap_durum'] == 0) {$durumrenk = "color:green;";} else{ $durumrenk = "color:red;";}
        
            
        ?>

        <tr>
                                    <td><?php echo  $bilgiler["id"];?></td>
                                     <td><?php echo  $bilgiler["uye_kadi"];?></td>
                                    <td><?php echo  $bilgiler["uye_password"];?></td>
                                    <td><?php  if($bilgiler["slug"] == ""){$hesapslug="Slug Yok";} else {$hesapslug=$bilgiler["slug"];} echo $hesapslug;  ?></td>
                                    <td>  <?php  if($bilgiler["uye_yetki"] == 1){$yetkidurumu="Admin";}elseif($bilgiler["uye_yetki"] == 0){$yetkidurumu="Kullanıcı";}  echo  $yetkidurumu;?></td>   
                                    <td> <?php if($bilgiler["uye_hesap_durum"] == 1){$hesapdurumu="Pasif";} else {$hesapdurumu="Aktif";} echo '<b style="'.$durumrenk.'">'.$hesapdurumu;  ?> </td>   
                                            
                                            
                                    <td>  
                                            <div class="form-group col-12" > 
                        <a class="btn" style="text-align:center !important; width:50%;" onclick="return confirm('Üye Aktif Edilecek Onaylıyormusunuz')" href="pages_admin/duzenle/uye_aktif_et.php?id=<?php echo $bilgiler['id']?>" class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i> Aktif Et</a>
                        <a class="btn"  style="text-align:center !important; width:50%;"onclick="return confirm('Veri Pasif Edilecek Onaylıyormusunuz')" href="pages_admin/duzenle/uye_pasif_et.php?id=<?php echo $bilgiler['id']?>" class="btn_1 gray delete"><i class="fa fa-fw fa-times-circle-o"></i> Pasif Et</a>
                </div> 
                                            <div class="form-group col-12" >
                                           <a class="btn" style="text-align:center !important; width:50%;" href="pages_admin/duzenle/uye_hesap_duzenle.php?id=<?php echo $bilgiler['id']?>" class="btn_1 gray approve"><i class="fa fa-fw fa-check-circle-o"></i> Düzenle</a>
     
                        <a  class="btn"  style="text-align:center !important; width:50%;" onclick="return confirm('Veri silinecek Onaylıyormusunuz')" href="pages_admin/duzenle/uye_sil.php?id=<?php echo $bilgiler['id']?>" class="btn_1 gray delete"><i class="fa fa-fw fa-times-circle-o"></i> Sil</a>
                </div></td>
                                    </tr>

   <?php }} ?>
                            
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table --> 
    </div>
</section>
<script src="assets/bundles/datatablescripts.bundle.js"></script>
<script src="assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js --> 
<script src="assets/js/pages/tables/jquery-datatable.js"></script>
<?php }?>