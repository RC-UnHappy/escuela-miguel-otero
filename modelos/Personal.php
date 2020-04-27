<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

#Se incluye la clase Persona
require_once 'Persona.php';

/**
 * Modelo de Personal
 */
class Personal //extends Persona
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idpersona, $cargo, $estatus)
	{
		$sql = "INSERT INTO personal (id, idpersona, cargo, estatus) VALUES(NULL, '$idpersona', '$cargo', '$estatus')";

		return ejecutarConsulta_retornarID($sql);
	}

	#Método para editar registros
	function editar($id, $cargo)
	{
		$sql = "UPDATE personal SET cargo='$cargo' WHERE id = '$id'";

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
		$sql = "SELECT p.cedula, p.p_nombre, p.p_apellido, p.email, pe.estatus, pe.id, pe.cargo, (SELECT telefono FROM telefono WHERE tipo = 'M' AND p.id = idpersona) as celular, (SELECT telefono FROM telefono WHERE tipo = 'F' AND p.id = idpersona) as fijo FROM persona as p INNER JOIN personal as pe ON p.id = pe.idpersona";

		return ejecutarConsulta($sql);
	}

	function mostrar($idpersonal)
	{
		$sql = "SELECT p.cedula, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, p.genero, p.f_nac, p.email, pe.cargo, pe.id, (SELECT telefono FROM telefono WHERE tipo = 'M' AND idpersona = p.id) as movil, (SELECT telefono FROM telefono WHERE tipo = 'F' AND idpersona = p.id) as fijo, (SELECT GROUP_CONCAT(cargo) FROM personal_directivo WHERE idpersonal = '$idpersonal' AND estatus = 1) as cargos_directivos FROM persona p INNER JOIN personal pe ON p.id = pe.idpersona WHERE pe.id = '$idpersonal'";

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para obtener el id de la persona
	function idpersona($idpersonal)
	{
		$sql = "SELECT idpersona FROM personal WHERE id = '$idpersonal'";

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para desactivar idpersonal
	function desactivar($idpersonal)
	{
		$sql = "UPDATE personal SET estatus = '0' WHERE id = '$idpersonal'";

		return ejecutarConsulta($sql);
	}

	#Método para activar idpersonal
	function activar($idpersonal)
	{
		$sql = "UPDATE personal SET estatus = '1' WHERE id = '$idpersonal'";

		return ejecutarConsulta($sql);
	}

	#Método para comprobar si existe el personal
	function comprobarpersonal($cedula)
	{
		$sql = "SELECT p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal pe ON pe.idpersona = p.id WHERE p.cedula = '$cedula'";
		return ejecutarConsulta($sql);
	}

	#Método para comprobar si existe la persona
	function comprobarpersona($cedula)
	{
		$sql = "SELECT p.id, p.cedula, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, p.genero, p.f_nac, p.email, GROUP_CONCAT(IF(t.tipo = 'M', t.telefono, null)) celular, GROUP_CONCAT(IF(t.tipo = 'F', t.telefono, null)) fijo FROM persona p LEFT JOIN telefono t ON p.id = t.idpersona WHERE p.cedula = '$cedula'";

		return ejecutarConsulta($sql);
  }
  
  #Método para traer el id del período escolar activo
	function consultarperiodo()
	{
		$sql = "SELECT id FROM periodo_escolar WHERE estatus = 'Activo'";
		return ejecutarConsultaSimpleFila($sql);
  }
  
  /**
   * Método para quitar los cargos directivos
   *
   * @param bool $cargos
   * @return void
   */
  function quitar_cargo_directivo($cargos)
  {
    $sw = TRUE;
    if (!empty($cargos)) {
      foreach ($cargos as $key => $value) {
        $sql = "UPDATE personal_directivo SET fecha_fin = CURDATE(), estatus = 0 WHERE cargo = '$value' AND estatus = 1";
        ejecutarConsulta($sql) or $sw = FALSE;
      }
    } 
    
    return $sw;
  }

  function asignar_cargo_directivo($idpersonal, $idperiodo_escolar, $cargos)
  {
    $sw = TRUE;

    if (!empty($cargos)) {
      foreach ($cargos as $key => $value) {
        $sql = "INSERT INTO personal_directivo (idpersonal, idperiodo_escolar, cargo, fecha_inicio, estatus) VALUES ('$idpersonal', '$idperiodo_escolar', '$value', CURDATE(), 1)";
        ejecutarConsulta($sql) or $sw = FALSE;
      }
    }

    return $sw;
  }

  function traerpersonaldirectivo($cargo)
  {
    $sql = "SELECT per.p_nombre, per.p_apellido FROM personal_directivo per_dir INNER JOIN personal ON per_dir.idpersonal = personal.id INNER JOIN persona per ON personal.idpersona = per.id WHERE per_dir.cargo = '$cargo' AND per_dir.estatus = 1";

    return ejecutarConsultaSimpleFila($sql);
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


