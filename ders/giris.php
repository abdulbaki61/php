<?php include "header.php"; ?>


<form method="post" action="" class="giris-form">
    <input type="text" name="uye_adi" placeholder="Kullanıcı Adınız">
    <input type="password" name="uye_sifre" placeholder="Şifreniz">
    <button value="1" name="girisyap">Giriş Yap</button>
</form>
<?php

if(isset($_POST["girisyap"])){


    $uye_adi = $_POST["uye_adi"];
    $uye_sifre = $_POST["uye_sifre"];
    
    $uyesor = $db->prepare("select * from uyeler where uye_adi=:adi and uye_sifre=:sifre");
    $uyesor->execute(array('adi' => $uye_adi, 'sifre' => md5($uye_sifre)));
    $uyecek = $uyesor->fetch(PDO::FETCH_ASSOC);
    $uyekontrol = $uyesor->rowCount();
    
    if($uyekontrol){
    $_SESSION["uye_adi"] = $uye_adi;
    $uye_id = $uyecek["uye_id"];
    header("Location: profil.php?uye_adi=$uye_adi&uye_id=$uye_id");    
    }




}








include "footer.php"; ?>
