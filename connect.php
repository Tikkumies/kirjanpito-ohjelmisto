<?php
$dsn = 'mysql:host=127.0.0.1;dbname=kirjanpito';
$username = 'root';
$password = '';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 

$dbh = new PDO($dsn, $username, $password, $options);

$tuote = $_GET["tyyppi"];
$hinta = $_GET["hinta"];

$sql = "INSERT INTO kustannukset(tuoteryhma, hinta)
    VALUES(:tyyppi, :hinta)";
	
$query = $dbh->prepare($sql);
$results = $query->execute(array(
	":tyyppi" => $tuote,
	":hinta"=> $hinta
	));
	
echo "Tieto tallennettu";

header("Location: http://localhost/kirjanpito/kustannukset.html")
?>
