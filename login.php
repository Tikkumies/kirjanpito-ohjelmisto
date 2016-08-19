<?php
	session_start();
	
	//DB configuration Constants
	
	$dsn = 'mysql:host=127.0.0.1;dbname=kirjanpito';
	$username = 'root';
	$password = '';
    
$databaseConnection = new PDO($dsn, $username, $password);
	/*
	define('_HOST_NAME_', '127.0.0.1');
	define('_USER_NAME_', 'root');
	define('_DB_PASSWORD', '');
	define('_DATABASE_NAME_', 'kirjanpito');
	*/
	//PDO Database Connection
	try {
		$databaseConnection = new PDO($host,$db,$pass);
		$databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}
	
	if(isset($_POST['submit'])){
		$errMsg = '';
		//username and password sent from Form
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		if($username == '')
			$errMsg .= 'You must enter your Username<br>';
		
		if($password == '')
			$errMsg .= 'You must enter your Password<br>';
		
		if($errMsg == ''){
			$records = $databaseConnection->prepare('SELECT id,username,password FROM  tbl_users WHERE username = :username');
			$records->bindParam(':username', $username);
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			
			if(count($results) > 0 && password_verify($password, $results['password'])){
				$_SESSION['username'] = $results['username'];
				echo $results;
				header('location:dashboard.php');
				exit;
			}else{
				$errMsg .= 'Username and Password are not found<br>';
			}
		}
	}
 
?>
 
 
<html>
<head><title>Login Page PHP Script</title></head>
<body>
	<div align="center">
		<div style="width:300px; border: solid 1px #006D9C; " align="left">
			<?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.$username'</div>';
					
				}
			?>
			<div style="background-color:#006D9C; color:#FFFFFF; padding:3px;"><b>Login</b></div>
			<div style="margin:30px">
				<form action="" method="post">
				
					<label>Username  :</label><input type="text" name="username" class="box"/><br /><br />
					<label>Password  :</label><input type="password" name="password" class="box" /><br/><br />
					<input type="submit" name='submit' value="Submit" class='submit'/><br />
				</form>
			</div>
		</div>
	</div>
</body>
</html>