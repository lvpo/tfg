<?php
require_once 'resources/library/PHPExcel.php';
require_once 'resources/library/PHPExcel/IOFactory.php';
include_once('clases.php');
include_once('dataGameCreate.php');
define('FILA_CABECERA_JUEGO',2);
define('FILA_CABECERA_RANGOS',4);
define ('COLOR_CABECERAS','000000');
//Errores
$listaErrores = array();

	function procesarCabeceraJuego($worksheet){	
		$id=-1;
		$row= FILA_CABECERA_JUEGO;
		$juego = new Juego();
		$juego->nombre = $worksheet->getCellByColumnAndRow(0, $row);
		$juego->descripcion = $worksheet->getCellByColumnAndRow(1, $row);
		$juego->dado = $worksheet->getCellByColumnAndRow(2, $row);
		$juego->tipo = $worksheet->getCellByColumnAndRow(3, $row);
		$juego->maxJugadores = $worksheet->getCellByColumnAndRow(4, $row);
		$juego->multidireccional = $worksheet->getCellByColumnAndRow(5, $row);
		$juego->tiempoJuego = $worksheet->getCellByColumnAndRow(6, $row);
		$juego->nivel = $worksheet->getCellByColumnAndRow(7, $row);
		$juego->tema = $worksheet->getCellByColumnAndRow(8, $row);		
		
		//$id= crearJuego($juego);
		//if ($id!=-1)
		//	echo "Juego '$juego->nombre' creado.";
		//return $id;
		return $juego;
	}
	
	//Devuelve la lista de rangos y el número de fila donde empieza la cabecera del tablero
	function obtenerRangos($worksheet){
	
		try{
		$row=FILA_CABECERA_RANGOS;
		$listaRangos = array();
		
		while($worksheet->getCellByColumnAndRow(0,$row)!='Tablero'){
			$auxRango = new Rango();
			$auxRango->color = $worksheet->getCellByColumnAndRow(0,$row)->getStyle()->getFill()->getStartColor()->getRGB();
			$auxRango->nivel = $worksheet->getCellByColumnAndRow(0,$row);
			$auxRango->tema = $worksheet->getCellByColumnAndRow(1,$row);
			$auxRango->premio= $worksheet->getCellByColumnAndRow(2,$row);
			$auxRango->cantidadPremio = $worksheet->getCellByColumnAndRow(3,$row);
			$auxRango->PierdeTurno = $worksheet->getCellByColumnAndRow(4,$row);
			$auxRango->castigo = $worksheet->getCellByColumnAndRow(5,$row);
			$auxRango->tipo = $worksheet->getCellByColumnAndRow(6,$row);
			$auxRango->condicionGanar = $worksheet->getCellByColumnAndRow(7,$row);		
			$listaRangos[]=$auxRango;
			$row++;
		}
		$resul= array();
		$resul[]=$row;
		$resul[]=$listaRangos;
		return $resul;	
		}catch(Exception $e){
			throw new Exception($row+";"+$e->getMessage());		
		}
	}
	
function buscarRango($listaRangos,$color){
	
	for($i=0;$i<count($listaRangos);$i++){
		if ($listaRangos[$i]->color==$color)
			return $listaRangos[$i];	
	}
	return null;

}
	

function procesarTablero($worksheet,$row,$maxCol,$listaRango){
	try{
	$x=0;
	$rowTablero= $worksheet->getHighestRow()-$row;
	
	
	$casillas=array();
	while ($x<=$rowTablero){
		$y=0;
		while($y<=$maxCol){
		
			$aux= $worksheet->getCellByColumnAndRow($y,$x+$row);			
			if (strlen($aux)>0){
			$color=$aux->getStyle()->getFill()->getStartColor()->getRGB();
			$rango=buscarRango($listaRango,$color);
			$casilla = new Casilla();
			if ($rango!=null){
				$casilla->nivel=$rango->nivel;
				$casilla->tema = $rango->tema;
				$casilla->premio = $rango->premio;
				$casilla->cantidadPremio=$rango->cantidadPremio;
				$casilla->pierdeTurno=$rango->pierdeTurno;
				$casilla->castigo=$rango->castigo;		
			}
				
			$casilla->cordX=$x;
			$casilla->cordY=$y;
			//$casilla->idJuego=$idJuego;
			$casilla->color=$color;
			$casilla=procesarCasilla($aux,$casilla);
			//crearCasilla($casilla);
			$casillas[]=$casilla;
			}
			$y++;
		}
		$x++;
	}
	
	return $casillas;
	}catch(Exception $e){
			throw new Exception($row+";"+$e->getMessage());		
		}
	
	}

function procesarCasilla($celda,$casilla){		
	$aux= explode("|", $celda);	
	return parseCasilla($aux,$casilla);
}

//Parsea el formato de la celda del Excel al objeto Casilla.
//Formato: nombreCasilla|Ini|fin|destPremio|destCastigo|Nivel|Tema|Premio|CantidadPremio|PierdeTurno|Castigo|CondiciónGanar

function parseCasilla($arr, $casilla){
	for ($i=0;$i<count($arr);$i++){
		switch ($i){
		
		case 0:
			$casilla->nombre=$arr[$i];
			break;
		case 1:
			$casilla->ini=$arr[$i];
			break;
		case 2:			
			$casilla->fin=$arr[$i];
			break;
		case 3:
		if (strlen($arr[$i]!=0))
			$casilla->destPremio=$arr[$i];
			break;
		case 4:
		if (strlen($arr[$i]!=0))
			$casilla->destCastigo=$arr[$i];
			break;
		case 5:
		if (strlen($arr[$i]!=0))
			$casilla->nivel=$arr[$i];
			break;
		case 6:
		if (strlen($arr[$i]!=0))
			$casilla->tema=$arr[$i];
			break;
		case 7:
		if (strlen($arr[$i]!=0))
			$casilla->premio=$arr[$i];
			break;
		case 8:
		if (strlen($arr[$i]!=0))
			$casilla->cantPremio=$arr[$i];
			break;
		case 9:
		if (strlen($arr[$i]!=0))
			$casilla->pierdeTurno=$arr[$i];
			break;
		case 10:
		if (strlen($arr[$i]!=0))
			$casilla->castigo=$arr[$i];
			break;
		case 11:
		if (strlen($arr[$i]!=0))
			$casilla->condGanar=$arr[$i];
			break;
		default: break;	
		}
		}
		
	return $casilla;

}

try{
$fileName = $_FILES["file1"]["name"]; // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}


	
$objPHPExcel = PHPExcel_IOFactory::load("test_uploads/$fileName");


foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    //$worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    //$nrColumns = ord($highestColumn) - 64;
   // echo "<br>The worksheet ".$worksheetTitle." has ";
   // echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
   // echo ' and ' . $highestRow . ' row.';
    
	
	$juego = procesarCabeceraJuego($worksheet);

    $array = obtenerRangos($worksheet);
	$row = $array[0];
	$rangos = $array[1];
	$row++;
	//procesarTablero($worksheet, $highestRow-$row, $highestColumnIndex,$idJuego);
	$tablero=procesarTablero($worksheet, $row, $highestColumnIndex,$rangos);
	
	crearJuegoTablero($juego,$tablero);
	
	echo "Juego generado correctamente.";
}

if(move_uploaded_file($fileTmpLoc, "test_uploads/$fileName")){
    echo "";
} else {
    echo "move_uploaded_file function failed";
}

}catch (Exception $e){
	$a=$e->getMessage();
	echo $a;

}	
?>

