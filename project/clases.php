<?php 

class Juego{
        public $id;
	public $nombre;
	public $descripcion;
	public $dado;
	public $maxJugadores;
	public $multidireccional;
	public $tiempo;
	public $nivel;
	public $tema;
        public $foto;

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

class Casilla implements JsonSerializable{
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
	
	
	// public function __construct($rango){
	// if (rango!=null){
	// $nivel=$rango->nivel;
	// $tema = $rango->tema;
	// $premio = $rango->premio;
	// $cantidadPremio=$rango->cantidadPremio;
	// $pierdeTurno=$rango->pierdeTurno;
	// $castigo=$rango->castigo;
	// }
	//}
	
	public function jsonSerialize() {
        return [
			'nombre' => $this->nombre,
            'color' => $this->color,
            'cordX' => $this->cordX,
			'cordY' => $this->cordY,
			'inicial' => $this->ini,
			'idJuego' => $this->idJuego
        ];
    }

}

class Usuario{

	public $id;
	public $email;
	public $pass;
	public $nombre;
	public $apellidos;
	public $foto;
	public $online;
	public $baja;

}

class Pregunta implements JsonSerializable{

	public $id;	
	public $descripcion;
	public $correcta;
	public $respuestas;
	public function jsonSerialize() {
        return [
			'id' => $this->id,
			'descripcion' => $this->descripcion,
            'correcta' => $this->correcta,
            'respuestas' => $this->respuestas,
        ];
    }

}



?>