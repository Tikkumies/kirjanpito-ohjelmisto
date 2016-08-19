<?php

require_once("session.php");

$dsn = 'mysql:host=127.0.0.1;dbname=kirjanpito';
$username = 'root';
$password = '';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 
$dbh = new PDO($dsn, $username, $password, $options);
$tuote = $_GET["tyyppi"];
$hinta = $_GET["hinta"];
$date = date("Y-m-d");
$sql = "INSERT INTO kustannukset(tuoteryhma, hinta, pvm)
    VALUES(:tyyppi, :hinta, :pvm)";
	
$query = $dbh->prepare($sql);
$results = $query->execute(array(
	":tyyppi" => $tuote,
	":hinta"=> $hinta,
	":pvm"=> $date
	));
	
header("Location: http://localhost/kirjanpito/login/kustannukset.php")
?>