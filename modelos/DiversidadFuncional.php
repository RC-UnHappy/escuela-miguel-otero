<?php

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Diversidad Funcional
 */
class DiversidadFuncional
{

	#Constructor de la clase
	public function __construct()
	{
	}

	#Método para insertar registros
	function insertar($idaspecto_fisiologico, $diversidad)
	{
		$sw = TRUE;

		if ($diversidad != '') {
			for ($i = 0; $i < count($diversidad); $i++) {
				$sql = "INSERT INTO diversidad_funcionals (id, idaspecto_fisiologico, diversidad) VALUES(NULL, '$idaspecto_fisiologico' ,'$diversidad[$i]')";

				ejecutarConsulta($sql) or $sw = FALSE;
			}
		}

		return $sw;
	}

	#Método para eliminar registros
	function eliminar($idaspecto_fisiologico)
	{
		$sql = "DELETE FROM diversidad_funcionals WHERE idaspecto_fisiologico = '$idaspecto_fisiologico'";

		return ejecutarConsulta($sql);
	}

	#Método para insertar registros
	function insertar_crud($diversidad, $estatus)
	{
		$sql = "INSERT INTO diversidades_crud (diversidad, estatus) VALUES('$diversidad', '$estatus')";

		return ejecutarConsulta($sql);
	}

	function editar($iddiversidad, $diversidad, $estatus)
	{
		$sql = "UPDATE diversidades_crud SET diversidad='$diversidad', estatus = '$estatus' WHERE id = '$iddiversidad'";

		return ejecutarConsulta($sql);
	}

	function listar()
	{
		$sql = "SELECT * FROM diversidades_crud";

		return ejecutarConsulta($sql);
	}

	function mostrar($iddiversidad)
	{
		$sql = "SELECT * FROM diversidades_crud WHERE id = '$iddiversidad'";

		return ejecutarConsultaSimpleFila($sql);
	}

	function desactivar($iddiversidad)
	{
		$sql = "UPDATE diversidades_crud SET estatus = '0' WHERE id = '$iddiversidad'";

		return ejecutarConsulta($sql);
	}

	function activar($iddiversidad)
	{
		$sql = "UPDATE diversidades_crud SET estatus = '1' WHERE id = '$iddiversidad'";

		return ejecutarConsulta($sql);
	}
}
