<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de ExpresionLiteral
 */
class ExpresionLiteral
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($literal, $interpretacion, $estatus)
	{
		$sql = "INSERT INTO expresion_literal (literal, interpretacion, estatus) VALUES('$literal', '$interpretacion', '$estatus')";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($idliteral, $literal, $interpretacion, $estatus)
	{
		$sql = "UPDATE expresion_literal SET literal='$literal', interpretacion='$interpretacion', estatus = '$estatus' WHERE id = '$idliteral'";

		return ejecutarConsulta($sql);

	}

	#Método para listar todos las materiaes
	function listar()
	{
		$sql = "SELECT * FROM expresion_literal";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar un literal
	function mostrar($idliteral)
	{
		$sql = "SELECT * FROM expresion_literal WHERE id = '$idliteral'";

		return ejecutarConsultaSimpleFila($sql);
	}

	

	#Método para desactivar literal
	function desactivar($idliteral)
	{
		$sql = "UPDATE expresion_literal SET estatus = '0' WHERE id = '$idliteral'";

		return ejecutarConsulta($sql);

	}

	#Método para activar literal
	function activar($idliteral)
	{
		$sql = "UPDATE expresion_literal SET estatus = '1' WHERE id = '$idliteral'";

		return ejecutarConsulta($sql);

	}

	#Método para comprobar si existe el literal
	function comprobarliteral($literal)
	{
		$sql = "SELECT literal FROM expresion_literal WHERE literal = '$literal'";
		return ejecutarConsulta($sql);
	}
	
}


