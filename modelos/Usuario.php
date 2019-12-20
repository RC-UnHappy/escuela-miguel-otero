<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

#Se incluye la clase Persona
require_once 'Persona.php';

/**
 * Modelo de Usuario
 */
class Usuario //extends Persona
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idpersona, $usuario, $clave, $rol, $img, $i_fallidos, $estatus, $permisos)
	{
		$sql = "INSERT INTO usuario (idpersona, usuario, clave, rol, img, i_fallidos, estatus) VALUES('$idpersona', '$usuario', '$clave', '$rol', '$img', '$i_fallidos', '$estatus')";

		$idusuarionew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($permisos)) {
			$sql_detalle = "INSERT INTO usuario_permiso (idusuario, idpermiso) VALUES('$idusuarionew', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos = $num_elementos + 1;
		}

		return $sw;
	}

	#Método para editar registros
	function editar($id, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac)
	{
		$sql = "UPDATE persona SET cedula='$cedula', p_nombre = '$p_nombre', s_nombre = '$s_nombre', p_apellido = '$p_apellido', s_apellido = '$s_apellido', genero = '$genero', f_nac = '$f_nac'  WHERE id = '$id'";

		return ejecutarConsulta($sql);

	}

	#Método para obtener los permisos de un usuario
	function listarmarcados($idusuario) {
		$sql = "SELECT * FROM usuario_permiso WHERE idusuario = '$idusuario'";

		return ejecutarConsulta($sql);
	}

	#Método para listar todos los usuarios
	function listar()
	{
		$sql = "SELECT p.p_nombre, p.p_apellido, p.email, u.usuario, u.rol, u.estatus, u.id FROM persona as p INNER JOIN usuario as u ON p.id = u.idpersona";

		return ejecutarConsulta($sql);
	}

	function mostrar($idusuario)
	{
		$sql = "SELECT * FROM usuario WHERE idusuario = '$idusuario'";

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para vefiricar el acceso al sistema
	function verificar($usuario, $clave)
	{
		$sql = "SELECT u.id, u.usuario, u.rol, u.img, p.p_nombre, p.p_apellido, p.genero, p.email FROM usuario as u INNER JOIN persona as p ON u.idpersona = p.id WHERE u.usuario = '$usuario' AND u.clave = '$clave' AND u.estatus = '1'";

		return ejecutarConsulta($sql);

	}

	#Método para desactivar usuarios
	function desactivar($idusuario)
	{
		$sql = "UPDATE usuario SET estatus = '0' WHERE id = '$idusuario'";

		return ejecutarConsulta($sql);

	}

	#Método para desactivar usuarios
	function activar($idusuario)
	{
		$sql = "UPDATE usuario SET estatus = '1' WHERE id = '$idusuario'";

		return ejecutarConsulta($sql);

	}

	#Método para comprobar si existe el usuario
	function comprobarusuario($cedula)
	{
		$sql = "SELECT usuario FROM usuario WHERE usuario = '$cedula'";
		return ejecutarConsulta($sql);
	}



	/*===========================================================
	=            Funciones relacionadas con Director            =
	===========================================================*/

	#Método para comprobar si hay un director asignado
	function comprobardirector()
	{
		$sql = "SELECT * FROM usuario WHERE rol = 'Director(a)'";
		return ejecutarConsulta($sql);
	}

	#Método para promover a un docente o personal a director
	function promoverdirector($idusuario)
	{
		$sql = "UPDATE usuario SET rol = 'Director(a)' WHERE id = '$idusuario'";
		return ejecutarConsulta($sql);
	}

	#Método para degradar a un director a docente o personal
	function degradardirector($idusuario)
	{
		$sql = "UPDATE usuario SET rol = 'Docente' WHERE id = '$idusuario'";
		return ejecutarConsulta($sql);
	}

	/*=====  End of Funciones relacionadas con Director  ======*/
	


	/*==============================================================
	=            Funciones relacionadas con Subdirector            =
	==============================================================*/
	
	#Método para comprobar si hay un director asignado
	function comprobarsubdirector()
	{
		$sql = "SELECT * FROM usuario WHERE rol = 'Subdirector(a)'";
		return ejecutarConsulta($sql);
	}

	#Método para promover a un docente o personal a director
	function promoversubdirector($idusuario)
	{
		$sql = "UPDATE usuario SET rol = 'Subdirector(a)' WHERE id = '$idusuario'";
		return ejecutarConsulta($sql);
	}

	#Método para degradar a un director a docente o personal
	function degradarsubdirector($idusuario)
	{
		$sql = "UPDATE usuario SET rol = 'Docente' WHERE id = '$idusuario'";
		return ejecutarConsulta($sql);
	}
	
	/*=====  End of Funciones relacionadas con Subdirector  ======*/
	
}


