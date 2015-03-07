<?php
    include_once "resources/database.php";
    $email = null;
	$password = null;
    if ( !empty($_POST['inputEmail'])) {
        $email= $_REQUEST['inputEmail'];
    }
	
	if ( !empty($_POST['inputPassword'])) {
        $password= $_REQUEST['inputPassword'];
    }
     
    if ( null==$email ) {
		echo 'window.location.href = "index.php";';	

    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM Usuario WHERE emailUsuario=? and passUsuario=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($email,$password));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
		
		if ($data!=null){
			echo 'ok';
		}
		else{
			echo 'error';
		}
    }
?>