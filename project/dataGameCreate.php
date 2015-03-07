<?php 
include_once ('conexionBD.php');
 include 'resources/database.php';
include_once ('clases.php');

function crearJuego($juego){
$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO juego(nombreJuego, descJuego, dado, maxJugadores, multidireccional, tiempo, idNivel, idTema) VALUES (?,?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($juego->nombre,$juego->descripcion,$juego->dado,$juego->maxJugadores, $juego->multidireccional, $juego->tiempo,$juego->nivel,$juego->tema));
            Database::disconnect();
			return $pdo->lastInsertId();
	$con = conectar();
}

function crearCasilla($casilla){

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "INSERT INTO casilla(nombreCasilla, idJuego) 
	VALUES (?,?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($casilla->nombre,$casilla->idJuego));
	Database::disconnect();
	return $pdo->lastInsertId();
}


function obtenerCasillas($juego){

$con = conectar();

$sql = "SELECT * FROM Casilla WHERE idJuego='$juego'";
$casillas = array();
$result = mysqli_query($con,$sql);

if ($result->num_rows <=0){ 
	return "No hay casillas en este tablero"; 
}
else{
    while($row = $result->fetch_assoc()) {
        $casilla = new casilla();
		$casilla->idJuego=$row["idJuego"];
        $casilla->nombre=$row["nombreCasilla"];
        $casilla->cordX=$row["cordX"];
        $casilla->cordY=$row["cordY"];
        $casilla->color=$row["color"];
		$casilla->ini=$row["inicio"];
        $casillas[]=$casilla;
    }
}

desconectar($con);
return $casillas;

}

function crearJuegoTablero($juego,$casillas){

try{
	$pdo = Database::connect();
	$pdo->beginTransaction(); 
	$sql = "INSERT INTO juego(nombreJuego, descJuego, dado, maxJugadores, multidireccional, tiempo, idNivel, idTema) VALUES (?,?,?,?,?,?,?,?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($juego->nombre,$juego->descripcion,$juego->dado,$juego->maxJugadores, $juego->multidireccional, $juego->tiempo,$juego->nivel,$juego->tema));
    $id=$pdo->lastInsertId();
			foreach($casillas as $casilla){
		$sql = "INSERT INTO casilla(nombreCasilla, idJuego, color, cordX, cordY) 
	VALUES (?,?,?,?,?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($casilla->nombre,$id,$casilla->color,$casilla->cordX,$casilla->cordY));

	}
		
    $pdo->commit(); 
	}catch(PDOExecption $e){
	$dbh->rollback(); 
	}


/* Consignar la transacción */
/*if (strlen($error) == 0) {
        mysqli_query($con, "COMMIT");
    } else {
        throw new Exception($error);
    }*/
}

function juegoListar(){
    
    $con = conectar();

$sql = "SELECT * FROM Juego";
$juegos = array();
$result = mysqli_query($con,$sql);

if ($result->num_rows <=0){ 
	return "No hay juegos"; 
}
else{
    while($row = $result->fetch_assoc()) {
        $juego = new juego();
        $juego->id=$row["idJuego"];
        $juego->nombre=$row["nombreJuego"];
        $juego->descripcion=$row["descJuego"];
        $juego->foto=$row["fotoJuego"];
        $juego->nivel=$row["idNivel"];
        $juego->tema=$row["idTema"];
        $juego->dado=$row["dado"];
        $juego->maxJugadores=$row["maxJugadores"];
        $juego->multidireccional=$row["multidireccional"];
        $juego->tiempo=$row["tiempo"];
        $juegos[]=$juego;
    }
}

desconectar($con);
return $juegos;
     
}

//De momento solo elige un número al azar dentro del rango de ids disponibles y busca esa pregunta
function preguntaAzar(){

	$r=rand(1,3);
	$con = conectar();
	$sql = "SELECT * FROM Pregunta WHERE idPregunta='$r'";
	$result = mysqli_query($con,$sql);
		if ($result->num_rows <=0){ 
		return "No hay pregunta"; 
	}
	else
	while($row=$result->fetch_assoc()){
	$pregunta = new Pregunta();
	$pregunta->id=$row["idPregunta"];
	$pregunta->descripcion=utf8_encode($row["descPregunta"]);
	}
	desconectar($con);
	return $pregunta;
}

//Accede a las respuestas de la pregunta y convierte todo en un array JSON
function JSONPregunta(){
	$pregunta=preguntaAzar();
	$con = conectar();
	$pregunta->respuestas=array();
	$sql = "SELECT * FROM PreguntaRespuesta NATURAL JOIN Respuesta WHERE idPregunta='$pregunta->id'";
	
	$result = mysqli_query($con,$sql);
	
	
	if ($result->num_rows <=0){ 
		return "No hay preguntas"; 
	}
	else{
		while($row = $result->fetch_assoc()) {
			
			if ($row["esCorrecta"]==1){
				$pregunta->correcta=utf8_encode($row["descRespuesta"]);}
				
				$pregunta->respuestas[]=utf8_encode($row["descRespuesta"]);
						
		}
		
		
	}
	
	desconectar($con);
	//return $pregunta;
	return [
			'id' => $pregunta->id,
			'descripcion' => $pregunta->descripcion,
            'correcta' => $pregunta->correcta,
            'respuestas' => $pregunta->respuestas
        ];



}

//Devuelve la casilla de destino que será la actual en JSON
//recibe el desplazamiento y la casilla sobre la que tendrá que averiguar hacia dónde ir
function JSONAvanza($casillaActual,$desplazamiento){
	

	$con = conectar();
	$des = $casillaActual->cordY + $desplazamiento;
	$sql = "SELECT * FROM Casilla where idJuego='$casillaActual->idJuego' and cordX='$casillaActual->cordX' and cordY='$des'";
	$casilla = new Casilla();
	$result = mysqli_query($con,$sql);

	if ($result->num_rows <=0){ 
		return "No hay casillas"; 
	}
	else{
		while($row = $result->fetch_assoc()) {			
			$casilla->color=$row["color"];
			$casilla->cordX=$row["cordX"];
			$casilla->cordY=$row["cordY"];
			$casilla->nombre=$row["nombreCasilla"];
			$casilla->idJuego=$row["idJuego"];
			$casilla->ini=$row["inicio"];
		}
		
		
	}
	
	desconectar($con);
	//return $pregunta;
	return $casilla;
}

?>