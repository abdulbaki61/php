<?php


try{


$db = new PDO("mysql:host=localhost;dbname=ders;charset=utf8","root","sifrem123");

}catch(PDOException $mesaj){

    echo $mesaj->getMessage();


}








?>
