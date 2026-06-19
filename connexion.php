<?php

try{
$conn = new PDO("mysql: host=localhost; dbname=pfe", "root", "");
}
catch (Exception $ex){
die("erreur de connexion". $ex->getMessage());
}


?>