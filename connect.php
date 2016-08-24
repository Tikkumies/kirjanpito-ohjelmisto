<?php

require_once("session.php");

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}

class kustannukset
{
	public function connect()
		{
		$dsn = 'mysql:host=127.0.0.1;dbname=kustannukset';
		$username = 'root';
		$password = '';
		$options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		); 
		try
		{
		$dbh = new PDO($dsn, $username, $password, $options);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
		}
		return $dbh;
		}
	
	public function insert_into($tuote, $hinta, $date)
		{
		$sql = "INSERT INTO kustannukset(tuoteryhma, hinta, pvm)
		VALUES(:tyyppi, :hinta, :pvm)";	
		$query = $this->connect()->prepare($sql);
		$results = $query->execute(array(
		":tyyppi" => $tuote,
		":hinta"=> $hinta,
		":pvm"=> $date
		));
		}
		
	public function read()
	{
		$sql = "SELECT tuoteryhma, hinta, pvm FROM kustannukset ORDER BY id DESC";
		$query = $this->connect()->prepare($sql);
		$query->execute();
		
		 $result = $query->setFetchMode(PDO::FETCH_ASSOC);
		 echo "<tr>
                  <th>Tuote</th>
                  <th>Hinta</th>
                  <th>Päivämäärä</th>
                  
                </tr>";
		foreach(new TableRows(new RecursiveArrayIterator($query->fetchAll())) as $k=>$v) {
        echo $v;
	}
}
}
?>