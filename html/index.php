<style>
  .logolar{width:100%; color:white; text-align:center;     font-size: 40px;}
  .logolar a{color:white;}
.menu.logolar{padding:0px !important;}


  .buyutec:hover
{
    z-index:4;
    -webkit-transform: scale(1.3);
    -ms-transform: scale(1.3);  
    -moz-transform: scale(1.3);
    transform: scale(1.3);
}


.clearleft{clear:left;}
  @media screen and (max-width:900px) {
.bossuan{display:none;}
  }


  .menu{
    list-style: none;
    display: block;
}

.menu li{
    display: inline;
    margin: 10px;
    position: relative;
}
 </style>


<?php
if(@$ayar->firma_id !== NULL AND $resultgiris->uye_hesap_durum != 1){ 
?>

    <!-- Parallax Pixel Background Animation -->
    <section class="animated-background">
      <div id="stars1"></div>
      <div id="stars2"></div>
      <div id="stars3"></div>
    </section>
    <!-- End of Parallax Pixel Background Animation -->



<?php  if($ayar->logo == "'logo.png'" OR $ayar->logo == NULL) {$hesaplogosu= "profile_av.jpg";} else {$hesaplogosu= "admin/".$ayar->logo;} ?>
    <a id="profilePicture" href="<?php echo $ayar->logourl ;?>" target="_blank">
      <img src="<?php echo $hesaplogosu ;?>" alt="Profile Picture">
    </a>

    
    
    <div id="userName">
    <?php echo $ayar->etiket ;?>
    </div>
    <div style="margin-top: 15px;" id="userName">
    <?php echo $ayar->baslik ;?>
    </div>
    <div id="links">

    <ul class="menu logolar">
    <?php 

// id değerini kullanarak frontbilgi tablosundaki ilgili satırları seçelim
$sql = "SELECT * FROM smhesapbilgileri WHERE firma_id = :firma_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':firma_id', $ayar->firma_id);
$stmt->execute();
$resultssm = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sonuçları ekrana yazdıralım
foreach ($resultssm as $row) {
                   if($row['smhesapdurum'] == 1){  ?> 
                    <li><a target="_blank" href="<?php echo $row['smhesapurl']; ?>"> <i class="<?php echo $row['smhesapicon']; ?> buyutec"></a></i></li>

<?php }} ?>
 
</ul>








    <?php 
$sql = "SELECT * FROM hesapbilgileri WHERE firma_id = :firma_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':firma_id', $ayar->firma_id);
$stmt->execute();
$resultshesap = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultshesap as $hesaplar) { 
                  if($hesaplar['hesapdurum'] == 1){  ?> 

<div class="sc-cBNfnY cHGPOa clearleft" style="left: 0px; top:30px; position:relative;"><div  class="sc-bdfBwQ sc-bBXqnf bIlyBn cDkMQC group" ><a href="<?php echo $hesaplar['hesapurl']; ?>" target="_blank" rel="noopener" data-testid="LinkButton" class="sc-pFZIQ sc-fKFyDc ldGKnQ hzhcpT group"  height="auto"><div data-testid="LinkThumbnail" class="sc-bdfBwQ sc-gsTCUz sc-hHftDr gZIEiX bhdLno hxSEDk" ><img data-testid="LinkThumbnailImage" src="<?php echo $urlfoto.$hesaplar['image_file'] ;?>" alt="<?php echo $hesaplar['image_name'] ;?>" loading="lazy" class="sc-iBPRYJ sc-dmlrTW gLxBPj hzKFm"></div><p class="sc-hKgILt sc-jNMdTA cxwgnw kFCyzt"><?php echo $hesaplar['hesapadi'] ;?></p></a></div></div>
<?php }} ?>


    <div id="hashtag">
      <b> <?php echo $ayar->hastag ;
 ?> </b>
    </div>


  
<?php }else{ header("Location:404", true, 301);

} ?>