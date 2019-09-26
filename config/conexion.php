<?php 

require_once 'global.php';

#Se crea la conexión a la bd
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

#Se establece el conjunto de caráteres
mysqli_query($conexion, 'SET NAMES "'.DB_ENCODE.'"');

#Si tenemos un error en la conexión lo mostramos
if (mysqli_connect_errno()) {
	printf("Falló la conexión a la base de datos: %s\n",mysqli_connect_errno());
	exit();
}

#Si no existe la función ejecutarConsulta se crea
if (!function_exists('ejecutarConsulta')) {

	#Ejecuta una consulta y devuelve el objeto
	function ejecutarConsulta($sql)
	{
		global $conexion;
		$query = $conexion->query($sql);
		return $query;
	}

	#Ejecuta una consulta y devuelve un arreglo
	function ejecutarConsultaSimpleFila($sql)
	{
		global $conexion;
		$query = $conexion->query($sql);
		$row = $query->fetch_assoc();
		return $row;
	}

	#Ejecuta una consulta y devuelve el id del último registro
	function ejecutarConsulta_retornarID($sql)
	{
		global $conexion;
		$query = $conexion->query($sql);
		return $conexion->insert_id;
	}

	#Recibe una cadena de datos y los limpia
	function limpiarCadena($str)
	{
		global $conexion;
		$str = mysqli_real_escape_string($conexion, trim($str));
		return htmlspecialchars($str);
	}

	function autocommit($value)
	{
		global $conexion;
		$conexion->autocommit($value);
	}

	function commit()
	{
		global $conexion;
		$conexion->commit();
	}

	function rollback()
	{
		global $conexion;
		$conexion->rollback();
	}
	
}