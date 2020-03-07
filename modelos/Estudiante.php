<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

#Se incluye la clase Persona
require_once 'Persona.php';

/**
 * Modelo de Estudiante
 */
class Estudiante
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idpersona, $idmadre, $idpadre, $parto_multiple, $orden_nacimiento, $estatus)
	{
		$sql = "INSERT INTO estudiante (id, idpersona, idmadre, idpadre, parto_multiple, orden_nacimiento, estatus) VALUES(NULL, '$idpersona', '$idmadre', '$idpadre', '$parto_multiple', '$orden_nacimiento', '$estatus')";

		return ejecutarConsulta_retornarID($sql);

	}

	#Método para editar registros
	function editar($id, $idmadre, $idpadre, $parto_multiple, $orden_nacimiento)
	{
		$sql = "UPDATE estudiante SET idmadre='$idmadre', idpadre = '$idpadre', parto_multiple = '$parto_multiple', orden_nacimiento = '$orden_nacimiento' WHERE id = '$id'";

		return ejecutarConsulta($sql);

	}

	#Método para listar todos los estudiantes
	function listar()
	{
		$sql = "SELECT p.id as idP, e.id as idE, p.cedula as cedulaE, p.p_nombre as nombreE, p.p_apellido as apellidoE, p.f_nac as fechaE, e.idmadre, e.idpadre, e.estatus, pm.cedula as cedulaM, pp.cedula as cedulaP FROM estudiante as e INNER JOIN persona as p ON p.id = e.idpersona INNER JOIN persona as pm ON pm.id = e.idmadre INNER JOIN persona as pp ON pp.id = e.idpadre";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar un estudiante
	function mostrar($idestudiante)
	{
		$sql = "SELECT pe.cedula, pe.p_nombre, pe.s_nombre, pe.p_apellido, pe.s_apellido, pe.genero, pe.f_nac, e.id, e.idmadre, e.idpadre, e.parto_multiple, e.orden_nacimiento, e.estatus, d.idparroquia as idparroquiaresidencia, d.direccion, p.idmunicipio as idmunicipioresidencia, p.parroquia as parroquiaresidencia, m.idestado as idestadoresidencia, m.municipio as municipioresidencia, esta.estado as estadoresidencia, ln.idparroquia as  idparroquianacimiento, pn.idmunicipio as idmunicipionacimiento, pn.parroquia as parroquianacimiento, mn.idestado as idestadonacimiento, mn.municipio as municipionacimiento, en.idpais as idpaisnacimiento , en.estado as estadonacimiento, pan.pais as paisnacimiento, pm.cedula as cedulaM, pp.cedula as cedulaP, af.todas_vacunas, af.peso, af.talla, af.alergico, GROUP_CONCAT(DISTINCT df.diversidad) as diversidades, GROUP_CONCAT(DISTINCT enf.enfermedad) as enfermedades, aso.tipo_vivienda, aso.grupo_familiar, aso.ingreso_mensual, GROUP_CONCAT(DISTINCT sh.sosten) as sostenes, can.posee_canaima, can.condicion FROM persona pe INNER JOIN estudiante e ON pe.id = e.idpersona LEFT JOIN direccion d ON d.idpersona = pe.id LEFT JOIN parroquia p ON d.idparroquia = p.id LEFT JOIN municipio m ON m.id = p.idmunicipio LEFT JOIN estado esta ON esta.id = m.idestado LEFT JOIN lugar_nacimiento ln ON ln.idestudiante = e.id LEFT JOIN parroquia pn ON pn.id = ln.idparroquia LEFT JOIN municipio mn ON mn.id = pn.idmunicipio LEFT JOIN estado en ON en.id = mn.idestado LEFT JOIN pais pan ON pan.id = en.idpais INNER JOIN persona pm ON pm.id = e.idmadre LEFT JOIN persona pp ON pp.id = e.idpadre LEFT JOIN aspecto_fisiologico af ON af.idestudiante = e.id LEFT JOIN diversidad_funcional df ON df.idestudiante = e.id LEFT JOIN enfermedad enf ON enf.idestudiante = e.id INNER JOIN aspecto_socioeconomico as aso ON aso.idestudiante = e.id LEFT JOIN sosten_hogar sh ON sh.idestudiante = e.id inner JOIN canaima can ON can.idestudiante = e.id WHERE e.id = '$idestudiante'";

		return ejecutarConsulta($sql);
	}

	#Método para obtener el id de la persona
	function idpersona($idestudiante)
	{
		$sql = "SELECT idpersona FROM estudiante WHERE id = '$idestudiante'";

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para listar los paises
	function listarpaises()
	{
		$sql = "SELECT * FROM pais";

		return ejecutarConsulta($sql);
	}

  #Método para listar los estados
  function listarestados($idpais)
  {
  if ($idpais !== NULL)
    $sql = "SELECT * FROM estado WHERE idpais = '$idpais'";
  else
    $sql = "SELECT * FROM estado WHERE idpais = '232'";

  return ejecutarConsulta($sql);
  }

  #Método para listar los municipios
  function listarmunicipios($idestado)
  {
  if ($idestado !== NULL)
    $sql = "SELECT * FROM municipio WHERE idestado = '$idestado'";
  else
    $sql = "SELECT * FROM municipio";

  return ejecutarConsulta($sql);
  }

  #Método para listar las parroquias
  function listarparroquias($idmunicipio)
  {
  if ($idmunicipio !== NULL)
    $sql = "SELECT * FROM parroquia WHERE idmunicipio = '$idmunicipio'";
  else
    $sql = "SELECT * FROM parroquia";

  return ejecutarConsulta($sql);
  }

	#Método para comprobar si existe la persona
	function comprobarpadres($cedula, $genero)
	{
		$sql = "SELECT id, cedula, p_nombre, p_apellido FROM persona WHERE cedula = '$cedula' AND genero = '$genero'";	
		return ejecutarConsulta($sql);
	}
}