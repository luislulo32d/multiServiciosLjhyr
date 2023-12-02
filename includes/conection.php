<?php
$host = "localhost";
$user = "root";
$db = "multiserivicioljhyr";
$pass = "";

    try{
        $pdo = new PDO("mysql:host=$host;dbname=$db",$user,$pass);

    }catch(Exception $ex) {
        echo 'Error conectando a la base de datos. '.$ex->getMessage();
    }