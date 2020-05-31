<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Persona
 */
class Persona 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email)
	{
		$sql = "INSERT INTO persona (cedula, p_nombre, s_nombre, p_apellido, s_apellido, genero, f_nac, email, f_creacion) VALUES('$cedula', '$p_nombre', '$s_nombre', '$p_apellido', '$s_apellido', '$genero', '$f_nac', '$email', NOW())";
		 
		return ejecutarConsulta_retornarID($sql);
	}

	#Método para editar registros
	function editar($id, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email)
	{
		$sql = "UPDATE persona SET cedula='$cedula', p_nombre = '$p_nombre', s_nombre = '$s_nombre', p_apellido = '$p_apellido', s_apellido = '$s_apellido', genero = '$genero', f_nac = '$f_nac', email = '$email'  WHERE id = '$id'";

		return ejecutarConsulta($sql);

	}
}