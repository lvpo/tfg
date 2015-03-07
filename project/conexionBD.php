<?php 


function &conectar(){
$con = mysqli_connect("localhost","root","","tfg1");
	 
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

return $con;
}
function desconectar($con){
mysqli_close($con);
}

?>