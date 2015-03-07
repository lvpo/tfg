<?php
    include_once "resources/database.php";
    $email = null;
	$password = null;
    if ( !empty($_POST['inputEmail'])) {
        $email= $_POST['inputEmail'];
    }
	
	if ( !empty($_POST['inputPassword'])) {
        $password= $_POST['inputPassword'];
    }
     
    if ( null==$email ) {
       header("Location: index.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM Usuario WHERE emailUsuario=? and passUsuario=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($email,$password));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
		
		if ($data!=null){
			 //Almacenamos todos los datos del usuario en la sesión.
			 if ($data['bajaUsuario']==1){
				echo "<script type = \"text/javascript\">\n";
				echo "alert('Lo sentimos, su cuenta ha sido dado de baja. Póngase en contacto con el administrador');\n";
				echo 'window.location.href = "index.php";';
				echo "</script>";
			 
			 }
			 else{
				session_start();
				$_SESSION['id'] = $data['idUsuario'];
				$_SESSION['email'] = $data['emailUsuario']; 
				$_SESSION['nick_usuario'] = $data['nickUsuario'];
				$_SESSION['password'] = $data["passUsuario"];
				$_SESSION['nombre_usuario'] = $data['nombreUsuario'];
				$_SESSION['apellido_usuario'] = $data['apellidoUsuario'];
				$_SESSION['foto_usuario'] = $data['fotoUsuario'];
				$_SESSION['online_usuario'] = true;
				$_SESSION['baja_usuario'] = $data['bajaUsuario'];  
				$_SESSION['admin_usuario'] = $data['adminUsuario']; 
				
				 $pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE Usuario SET onlineUsuario=1 WHERE idUsuario=?";
				$q = $pdo->prepare($sql);
				$q->execute(array($data['idUsuario']));
				Database::disconnect();
					echo "<script type = \"text/javascript\">\n";
					echo 'window.location.href = "games.php";';
					echo "</script>";
			}
		}
		else{
		
		echo "<script type = \"text/javascript\">\n";
		echo "alert('Usuario o contraseña incorrectos.');\n";
		echo 'window.location.href = "index.php";';
		echo "</script>";
		}
    }
?>