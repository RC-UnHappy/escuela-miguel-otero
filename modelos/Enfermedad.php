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
			for ($i = 0; $i < count($enfermedad); $i++) {
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

	#Método para insertar registros
	function insertar_crud($enfermedad, $estatus)
	{
		$sql = "INSERT INTO enfermedades_crud (enfermedad, estatus) VALUES('$enfermedad', '$estatus')";

		return ejecutarConsulta($sql);
	}

	#Método para listar todos las enfermedad
	function listar()
	{
		$sql = "SELECT * FROM enfermedades_crud";

		return ejecutarConsulta($sql);
	}

	#Método para desactivar enfermedad
	function desactivar($idenfermedad)
	{
		$sql = "UPDATE enfermedades_crud SET estatus = '0' WHERE id = '$idenfermedad'";

		return ejecutarConsulta($sql);
	}

	#Método para activar enfermedad
	function activar($idenfermedad)
	{
		$sql = "UPDATE enfermedades_crud SET estatus = '1' WHERE id = '$idenfermedad'";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar una enfermedad
	function mostrar($idenfermedad)
	{
		$sql = "SELECT * FROM enfermedades_crud WHERE id = '$idenfermedad'";

		return ejecutarConsultaSimpleFila($sql);
	}

	function comprobarenfermedad($enfermedad)
	{
		$sql = "SELECT enfermedad FROM enfermedades_crud WHERE enfermedad = '$enfermedad'";
		return ejecutarConsulta($sql);
	}

	function editar($idenfermedad, $enfermedad, $estatus)
	{
		$sql = "UPDATE enfermedades_crud SET enfermedad='$enfermedad', estatus = '$estatus' WHERE id = '$idenfermedad'";

		return ejecutarConsulta($sql);
	}
}
