<?php include "header.php";

    $uyesor = $db->prepare("select * from uyeler where uye_adi=:adi and uye_id=:id");
    $uyesor->execute(array('adi' => $_GET["uye_adi"], 'id' => $_GET["uye_id"]));
    $uyecek = $uyesor->fetch(PDO::FETCH_ASSOC);
    $uyekontrol = $uyesor->rowCount();

?>

    <div class="profil">
        <ul>
            <li><img src="resimler/<?php 
            if(strlen($uyecek["uye_resim"] > 0)){
            echo $uyecek["uye_resim"];           
            }else{
            echo "kullanici-yok.jpg";
            }
            
            ?>
            "></li>
            <li>Kullanıcı Adı: <?php echo $uyecek["uye_adi"]; ?></li>
            <li>
            <a href="profil-duzenle.php?uye_adi=<?php echo $uyecek["uye_adi"] ?>&uye_id=<?php echo $uyecek["uye_id"] ?>">Profil Düzenle</a>
            </li>
            <li><a href="profil.php?durum=cikis">Çıkış Yap</a>
            </li>
        </ul>
    </div>
<?php
if(@$_GET["durum"] == "cikis"){
session_destroy();
header("Location: giris.php");
}



include "footer.php"; ?>
