<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Pic
 */
class Pic
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idperiodo_escolar, $pic, $estatus)
	{
		$sql = "INSERT INTO pic (idperiodo_escolar, pic, estatus) VALUES('$idperiodo_escolar', '$pic', '$estatus')";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($idpic, $idperiodo_escolar, $pic, $estatus)
	{
		$sql = "UPDATE pic SET pic='$pic' WHERE id = '$idpic'";

		return ejecutarConsulta($sql);

	}

	#Método para listar todos las materiaes
	function listar()
	{
		$sql = "SELECT pic.*, pe.periodo FROM pic pic INNER JOIN periodo_escolar pe ON pic.idperiodo_escolar = pe.id";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar una materia
	function mostrar($idpic)
	{
    $sql = "SELECT pic.*, pe.periodo FROM pic pic INNER JOIN periodo_escolar pe ON pe.id = pic.idperiodo_escolar WHERE pic.id = '$idpic'";
    
		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para activar idpic
	function activar($idpic)
	{
		$sql = "UPDATE pic SET estatus = 'Activo' WHERE id = '$idpic'";

		return ejecutarConsulta($sql);

	}
  
  #Método para traer el id del período escolar activo
	function consultarperiodo()
	{
		$sql = "SELECT id FROM periodo_escolar WHERE estatus = 'Activo'";
		return ejecutarConsultaSimpleFila($sql);
  }
  
  function traer_periodos_sin_proyecto()
  {
		$sql = "SELECT * FROM periodo_escolar WHERE id NOT IN (SELECT idperiodo_escolar FROM pic) AND estatus != 'Finalizado'";
		return ejecutarConsulta($sql);
  }
	
}