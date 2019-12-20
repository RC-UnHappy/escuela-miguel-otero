<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Aspecto Fisiológico
 */
class AspectoFisiologico 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idestudiante, $todas_vacunas, $peso, $talla, $alergico)
	{
		$sql = "INSERT INTO aspecto_fisiologico (id, idestudiante, todas_vacunas, peso, talla, alergico) VALUES(NULL, '$idestudiante', '$todas_vacunas', '$peso', '$talla', '$alergico')";

		return ejecutarConsulta($sql);

	}

}