<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

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
	function insertar($idpersona, $usuario, $clave, $rol, $intentos_fallidos, $estatus, $permisos)
	{
		$sql = "INSERT INTO usuario (idpersona, usuario, clave, rol, intentos_fallidos, estatus) VALUES('$idpersona', '$usuario', '$clave', '$rol', '$intentos_fallidos', '$estatus')";

		$idusuarionew = ejecutarConsulta_retornarID($sql);

		$sw = true;

    foreach ($permisos as $key => $value) {
      list($idmodulo, $idaccion) = explode('-', $value);

      $sql_detalle = "INSERT INTO usuario_modulo_accion (idusuario, idmodulo, idaccion) VALUES('$idusuarionew', '$idmodulo', '$idaccion')";

      ejecutarConsulta($sql_detalle) or $sw = false;
    }

		return $sw;
	}

	#Método para editar registros
	function editar($idusuario, $rol, $permisos)
	{
    $sw = true;

    $sql = "UPDATE usuario SET rol='$rol' WHERE id = '$idusuario'";

    ejecutarConsulta($sql) or $sw = FALSE;

    foreach ($permisos as $key => $value) {
      list($idmodulo, $idaccion) = explode('-', $value);

      $sql_detalle = "INSERT INTO usuario_modulo_accion (idusuario, idmodulo, idaccion) VALUES('$idusuario', '$idmodulo', '$idaccion')";

      ejecutarConsulta($sql_detalle) or $sw = false;
    }
    return $sw;
  }
  
  function eliminar_permisos_usuario($idusuario)
  {
    $sql = "DELETE FROM usuario_modulo_accion WHERE idusuario = '$idusuario'";
    return ejecutarConsulta($sql);
  }

	#Método para obtener los permisos de un usuario
	function traer_permisos_usuario($idusuario) {
		$sql = "SELECT * FROM usuario_modulo_accion WHERE idusuario = '$idusuario'";

		return ejecutarConsulta($sql);
  }
  
	#Método para obtener los permisos de un usuario pero en lugar del id el nombre del modulo y de la acción
	function traer_permisos_usuario_nombre($idusuario) {
		$sql = "SELECT uma.*, m.modulo, a.accion FROM usuario_modulo_accion uma INNER JOIN modulo m ON uma.idmodulo = m.id INNER JOIN accion a ON uma.idaccion = a.id WHERE idusuario = '$idusuario'";

		return ejecutarConsulta($sql);
	}

	#Método para listar todos los usuarios
	function listar()
	{
		$sql = "SELECT u.id, u.usuario, u.rol, u.intentos_fallidos, p.p_nombre, p.p_apellido, u.estatus FROM usuario as u INNER JOIN persona as p ON u.idpersona = p.id";

		return ejecutarConsulta($sql);
	}

	function mostrar($idusuario)
	{
		$sql = "SELECT usu.id as idusuario, usu.usuario, usu.rol as rol_usuario, per.* FROM usuario usu INNER JOIN persona per ON usu.idpersona = per.id WHERE usu.id = '$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para vefiricar el acceso al sistema
	function verificar($usuario, $clave)
	{
		$sql = "SELECT u.id, u.usuario, u.rol, p.p_nombre, p.p_apellido, p.genero FROM usuario as u INNER JOIN persona as p ON u.idpersona = p.id WHERE u.usuario = '$usuario' AND u.clave = '$clave' AND u.estatus = '1'";
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
  
  #Método para desactivar usuarios
	function resetear($idusuario, $cedula, $clavehash)
	{
		$sql = "UPDATE usuario SET usuario = '$cedula', clave = '$clavehash', intentos_fallidos = 0 WHERE id = '$idusuario'";

		return ejecutarConsulta($sql);

	}

	#Método para comprobar si existe la persona
	function comprobarpersona($cedula)
	{
    $sql = "SELECT * FROM persona WHERE cedula = '$cedula'";
		return ejecutarConsulta($sql);
	}

	#Método para traer los módulos
	function traermodulos()
	{
		$sql = "SELECT * FROM modulo ORDER BY modulo ASC";
		return ejecutarConsulta($sql);
  }
  
  #Método para traer las acciones
	function traeracciones()
	{
		$sql = "SELECT * FROM accion";
		return ejecutarConsulta($sql);
	}
	
	/*=====  End of Funciones relacionadas con Subdirector  ======*/
	
}


