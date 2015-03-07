<?php 

class Juego{
	public $nombre;
	public $descripcion;
	public $dado;
	public $maxJugadores;
	public $multidireccional;
	public $tiempo;
	public $nivel;
	public $tema;

}

class Rango{
	public $color;
	public $tema;
	public $nivel;
	public $premio;
	public $cantidadPremio;
	public $pierdeTurno;
	public $castigo;
	public $tipo;
	public $condicionGanar;
}

class Casilla{
	public $idJuego;
	public $ini;
	public $fin;
	public $nombre;
	public $color;
	public $tema;
	public $nivel;
	public $premio;
	public $cantidadPremio;
	public $pierdeTurno;
	public $castigo;
	
	public $destPremio;
	public $destCastigo;
	
	public $cordX;
	public $cordY;
	
	public $norte;
	public $sur;
	public $este;
	public $oeste;	
	
	
	public function __construct1($rango){
	
	$nivel=$rango->nivel;
	$tema = $rango->tema;
	$premio = $rango->premio;
	$cantidadPremio=$rango->cantidadPremio;
	$pierdeTurno=$rango->pierdeTurno;
	$castigo=$rango->castigo;
	
	
	
	}

}



?>