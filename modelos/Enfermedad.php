<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Enfermedad
 */
class Enfermedad 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idaspecto_fisiologico, $enfermedad)
	{
		$sw = TRUE;

		if ($enfermedad != '') {
			for ($i=0; $i < count($enfermedad) ; $i++) { 
				$sql = "INSERT INTO enfermedads (id, idaspecto_fisiologico ,enfermedad) VALUES(NULL, '$idaspecto_fisiologico', '$enfermedad[$i]')";
	
				ejecutarConsulta($sql) or $sw = FALSE;
			}
		}

		return $sw;
	}

	#Método para eliminar registros
	function eliminar($idaspecto_fisiologico)
	{
		$sql = "DELETE FROM enfermedads WHERE idaspecto_fisiologico = '$idaspecto_fisiologico'";

		return ejecutarConsulta($sql);	
	}

}