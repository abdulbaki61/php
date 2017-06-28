<?php include "header.php";

    $uyesor = $db->prepare("select * from uyeler where uye_adi=:adi and uye_id=:id");
    $uyesor->execute(array('adi' => $_GET["uye_adi"], 'id' => $_GET["uye_id"]));
    $uyecek = $uyesor->fetch(PDO::FETCH_ASSOC);
    $uyekontrol = $uyesor->rowCount();

?>

    <form class="profil-duzenle" method="post" action="" enctype="multipart/form-data">
        <input value="<?php echo $uyecek["uye_id"] ?>" name="uye_id" type="hidden">
        <img src="resimler/<?php 
            if(strlen($uyecek["uye_resim"] > 0)){
            echo $uyecek["uye_resim"];           
            }else{
            echo "kullanici-yok.jpg";
            }
            
            ?>">
        <label>Profil Resmini Değiştir: </label>
        <input type="file" name="uye_resim">
        <br>
        <label>Kullanıcı Adı: </label>
        <input type="text" name="uye_adi" value="<?php echo $uyecek["uye_adi"] ?>">
        <br>
        <button value="1" name="profilkaydet">Kaydet</button>
    </form>

    
<?php

if(isset($_POST["profilkaydet"])){

        $resimad = $uyecek["uye_resim"];
        $name = $_FILES["uye_resim"]["name"];
    // dosya varmı kontrol
    if(strlen($name) > 0){
        $yukleklasor = 'resimler/';
        $tmp_name = $_FILES["uye_resim"]["tmp_name"];
        $boyut = $_FILES["uye_resim"]["size"];
        $tip = $_FILES["uye_resim"]["type"];
        $uzanti = substr($name,-4,4);
        $randsayi1 = rand(10000,50000);
        $randsayi2 = rand(10000,50000);
        $resimad = $randsayi1.$randsayi2.$uzanti;
    
    // boyut kontrol
    if($boyut > (1024*1024*3)){
        echo "Dosya boyutu çok büyük!";
        exit;   
    }
    // tip kontrol
    if($tip !== 'image/jpeg' and $tip !== 'image/png' and $uzanti !== '.jpg'){
        echo "Yalnızca jpeg veya png formatında resim yüklenebilir!";
        exit();
    }
    $eskiresim = $uyecek["uye_resim"];
    unlink("resimler/".$eskiresim);

    // klasöre yükleme
    move_uploaded_file($tmp_name, "$yukleklasor/$resimad");
    
    }// varsa yap sonu

    $uyesor = $db->prepare("update uyeler set uye_adi=:adi, uye_resim=:resim where uye_id={$_POST['uye_id']}");
    $uyeguncelle = $uyesor->execute(array('adi' => $_POST["uye_adi"], 'resim' => $resimad));
    
    if($uyeguncelle){
        $uye_adi = $_POST["uye_adi"];
        $uye_id = $_POST["uye_id"];
        header("Location: profil.php?uye_adi=$uye_adi&uye_id=$uye_id");
    }else{
        echo "güncellenirken bir hata oluştu!";
    }


}





include "footer.php"; ?>
