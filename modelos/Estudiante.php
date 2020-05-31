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
    if (!empty($idpadre)) {
      $sql = "INSERT INTO estudiante (id, idpersona, idmadre, idpadre, parto_multiple, orden_nacimiento, estatus) VALUES(NULL, '$idpersona', '$idmadre', '$idpadre', '$parto_multiple', '$orden_nacimiento', '$estatus')";
    }
    else {
      $sql = "INSERT INTO estudiante (id, idpersona, idmadre, parto_multiple, orden_nacimiento, estatus) VALUES(NULL, '$idpersona', '$idmadre', '$parto_multiple', '$orden_nacimiento', '$estatus')";
    }

		return ejecutarConsulta_retornarID($sql);

	}

	#Método para editar registros
	function editar($id, $idmadre, $idpadre, $parto_multiple, $orden_nacimiento)
	{
    if (!empty($idpadre)) {
      $sql = "UPDATE estudiante SET idmadre='$idmadre', idpadre = '$idpadre', parto_multiple = '$parto_multiple', orden_nacimiento = '$orden_nacimiento' WHERE id = '$id'";
    }
    else {
      $sql = "UPDATE estudiante SET idmadre='$idmadre', idpadre = NULL, parto_multiple = '$parto_multiple', orden_nacimiento = '$orden_nacimiento' WHERE id = '$id'";
    }

		return ejecutarConsulta($sql);

	}

	#Método para listar todos los estudiantes
	function listar()
	{
		$sql = "SELECT p.id as idP, e.id as idE, p.cedula as cedulaE, p.p_nombre as nombreE, p.p_apellido as apellidoE, p.f_nac as fechaE, e.idmadre, e.idpadre, e.estatus, pm.cedula as cedulaM, pp.cedula as cedulaP FROM estudiante as e INNER JOIN persona as p ON p.id = e.idpersona INNER JOIN persona as pm ON pm.id = e.idmadre LEFT JOIN persona as pp ON pp.id = e.idpadre";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar un estudiante
	function mostrar($idestudiante)
	{
    // $sql = "SELECT pe.cedula, pe.p_nombre, pe.s_nombre, pe.p_apellido, pe.s_apellido, pe.genero, pe.f_nac, e.id, e.idmadre, e.idpadre, e.parto_multiple, e.orden_nacimiento, e.estatus, d.idparroquia as idparroquiaresidencia, d.direccion, p.idmunicipio as idmunicipioresidencia, p.parroquia as parroquiaresidencia, m.idestado as idestadoresidencia, m.municipio as municipioresidencia, esta.estado as estadoresidencia, ln.idparroquia as  idparroquianacimiento, pn.idmunicipio as idmunicipionacimiento, pn.parroquia as parroquianacimiento, mn.idestado as idestadonacimiento, mn.municipio as municipionacimiento, en.idpais as idpaisnacimiento , en.estado as estadonacimiento, pan.pais as paisnacimiento, pm.cedula as cedulaM, pp.cedula as cedulaP, af.todas_vacunas, af.peso, af.talla, af.alergico, GROUP_CONCAT(DISTINCT df.diversidad) as diversidades, GROUP_CONCAT(DISTINCT enf.enfermedad) as enfermedades, aso.tipo_vivienda, aso.grupo_familiar, aso.ingreso_mensual, GROUP_CONCAT(DISTINCT sh.sosten) as sostenes, can.posee_canaima, can.condicion FROM persona pe INNER JOIN estudiante e ON pe.id = e.idpersona LEFT JOIN direccion d ON d.idpersona = pe.id LEFT JOIN parroquia p ON d.idparroquia = p.id LEFT JOIN municipio m ON m.id = p.idmunicipio LEFT JOIN estado esta ON esta.id = m.idestado LEFT JOIN lugar_nacimiento ln ON ln.idestudiante = e.id LEFT JOIN parroquia pn ON pn.id = ln.idparroquia LEFT JOIN municipio mn ON mn.id = pn.idmunicipio LEFT JOIN estado en ON en.id = mn.idestado LEFT JOIN pais pan ON pan.id = en.idpais INNER JOIN persona pm ON pm.id = e.idmadre LEFT JOIN persona pp ON pp.id = e.idpadre LEFT JOIN aspecto_fisiologico af ON af.idestudiante = e.id LEFT JOIN diversidad_funcional df ON df.idestudiante = e.id LEFT JOIN enfermedad enf ON enf.idestudiante = e.id INNER JOIN aspecto_socioeconomico as aso ON aso.idestudiante = e.id LEFT JOIN sosten_hogar sh ON sh.idestudiante = e.id inner JOIN canaima can ON can.idestudiante = e.id WHERE e.id = '$idestudiante'";
    
    $sql = "SELECT pe.cedula, pe.p_nombre, pe.s_nombre, pe.p_apellido, pe.s_apellido, pe.genero, pe.f_nac, e.id, e.idmadre, e.idpadre, e.parto_multiple, e.orden_nacimiento, e.estatus, d.idparroquia as idparroquiaresidencia, d.direccion, p.idmunicipio as idmunicipioresidencia, p.parroquia as parroquiaresidencia, m.idestado as idestadoresidencia, m.municipio as municipioresidencia, esta.estado as estadoresidencia, ln.idparroquia as  idparroquianacimiento, pn.idmunicipio as idmunicipionacimiento, pn.parroquia as parroquianacimiento, mn.idestado as idestadonacimiento, mn.municipio as municipionacimiento, en.idpais as idpaisnacimiento , en.estado as estadonacimiento, pan.pais as paisnacimiento, pm.cedula as cedulaM, pp.cedula as cedulaP, aso.tipo_vivienda, aso.grupo_familiar, aso.ingreso_mensual, GROUP_CONCAT(DISTINCT sh.sosten) as sostenes, can.posee_canaima, can.condicion FROM persona pe INNER JOIN estudiante e ON pe.id = e.idpersona LEFT JOIN direccion d ON d.idpersona = pe.id LEFT JOIN parroquia p ON d.idparroquia = p.id LEFT JOIN municipio m ON m.id = p.idmunicipio LEFT JOIN estado esta ON esta.id = m.idestado LEFT JOIN lugar_nacimiento ln ON ln.idestudiante = e.id LEFT JOIN parroquia pn ON pn.id = ln.idparroquia LEFT JOIN municipio mn ON mn.id = pn.idmunicipio LEFT JOIN estado en ON en.id = mn.idestado LEFT JOIN pais pan ON pan.id = en.idpais INNER JOIN persona pm ON pm.id = e.idmadre LEFT JOIN persona pp ON pp.id = e.idpadre LEFT JOIN aspecto_socioeconomico as aso ON aso.idestudiante = e.id LEFT JOIN sosten_hogar sh ON sh.idestudiante = e.id LEFT JOIN canaima can ON can.idestudiante = e.id WHERE e.id = '$idestudiante'";

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

	function eliminar($idpersona)
	{
		$sql = "DELETE FROM persona WHERE id = '$idpersona'";

		return ejecutarConsulta($sql);
	}

	function mostrarretirar($idestudiante, $idpersona)
	{
		$sql = "SELECT per_est.cedula AS cedula_estudiante, per_est.p_nombre, per_est.s_nombre, per_est.p_apellido, per_est.s_apellido, gra.grado, ins.estatus, per_rep.cedula AS cedula_representante, per_rep.p_nombre AS p_nombre_representante, per_rep.s_nombre AS s_nombre_representante, per_rep.p_apellido AS p_apellido_representante, per_rep.s_apellido AS s_apellido_representante, pla.id AS id_ultima_planificacion FROM persona per_est INNER JOIN estudiante est ON per_est.id = est.idpersona INNER JOIN inscripcion ins ON ins.id = (SELECT MAX(id) FROM inscripcion WHERE idestudiante = est.id) INNER JOIN planificacion pla ON pla.id = ins.idplanificacion INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN representante rep ON rep.id = ins.idrepresentante INNER JOIN persona per_rep ON per_rep.id = rep.idpersona WHERE per_est.id = '$idpersona'";

		return ejecutarConsultaSimpleFila($sql);
	}

	function traerinscripciones($idestudiante)
	{
		$sql = "SELECT ins.*, gra.grado, sec.seccion, p_e.periodo, perso.cedula AS cedula_docente, perso.p_nombre AS nombre_docente, perso.p_apellido AS apellido_docente, bo_fi.descriptivo_final, ex_li.literal, peres.cedula AS cedula_estudiante, peres.p_nombre AS p_nombre_estudiante, peres.s_nombre AS s_nombre_estudiante, peres.p_apellido AS p_apellido_estudiante, peres.s_apellido AS s_apellido_estudiante, peres.f_nac AS f_nac_estudiante, peres.genero AS genero_estudiante, muni.municipio, (SELECT turno FROM institucion) AS turno, estu.idmadre, estu.idpadre FROM inscripcion ins INNER JOIN planificacion pla ON pla.id = ins.idplanificacion INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = pla.idseccion INNER JOIN periodo_escolar p_e ON p_e.id = pla.idperiodo_escolar INNER JOIN personal pernal ON pernal.id = pla.iddocente INNER JOIN persona perso ON perso.id = pernal.idpersona INNER JOIN estudiante estu ON ins.idestudiante = estu.id INNER JOIN persona peres ON estu.idpersona = peres.id INNER JOIN lugar_nacimiento lu_na ON lu_na.idestudiante = estu.id INNER JOIN parroquia parro ON parro.id = lu_na.idparroquia INNER JOIN municipio muni ON muni.id = parro.idmunicipio LEFT JOIN boletin_final bo_fi ON bo_fi.idplanificacion = ins.idplanificacion AND bo_fi.idestudiante = ins.idestudiante LEFT JOIN expresion_literal ex_li ON ex_li.id = bo_fi.idexpresion_literal  WHERE ins.idestudiante = '$idestudiante'";

		return ejecutarConsulta($sql);
	}

	function retirar($periodo_escolar, $turno, $grado, $seccion, $cedula_docente, $nombre_docente, $apellido_docente, $cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante, $fecha_nacimiento_estudiante, $lugar_nacimiento_estudiante, $sexo_estudiante, $literal, $observaciones, $estatus)
	{
		if ($estatus == 'CURSANDO') $estatus = 'RETIRADO';

		$sql = "INSERT INTO historial_estudiantil (periodo_escolar, turno, grado, seccion, cedula_docente, nombre_docente, apellido_docente, cedula_estudiante, p_nombre_estudiante, s_nombre_estudiante, p_apellido_estudiante, s_apellido_estudiante, fecha_nacimiento_estudiante, lugar_nacimiento_estudiante, sexo_estudiante, literal, observaciones, estatus, fecha_creacion) VALUES ('$periodo_escolar', '$turno', '$grado', '$seccion', '$cedula_docente', '$nombre_docente', '$apellido_docente', '$cedula_estudiante', '$p_nombre_estudiante', '$s_nombre_estudiante', '$p_apellido_estudiante', '$s_apellido_estudiante', '$fecha_nacimiento_estudiante', '$lugar_nacimiento_estudiante', '$sexo_estudiante', '$literal', '$observaciones', '$estatus', NOW() )";

		return ejecutarConsulta($sql);
	}


	public function verificar_representante_inscripcion($idrepresentante, $idestudiante)
	{
		$sql = "SELECT * FROM inscripcion WHERE idrepresentante = '$idrepresentante' AND idestudiante != '$idestudiante' ";
		return ejecutarConsulta($sql);
	}

	public function verificar_padre_idrepresentante($idrepresentante, $idestudiante)
	{
		$sql = "SELECT * FROM estudiante WHERE idmadre = (SELECT idpersona FROM representante WHERE id = '$idrepresentante') OR idmadre = (SELECT idpersona FROM representante WHERE id = '$idrepresentante') AND id != '$idestudiante'";
		return ejecutarConsulta($sql);
	}

	public function verificar_personal($idrepresentante)
	{
		$sql = "SELECT * FROM personal WHERE idpersona = (SELECT idpersona FROM representante WHERE id = '$idrepresentante') ";
		return ejecutarConsulta($sql);
	}

	function eliminar_persona_representante($idrepresentante)
	{
		$sql = "DELETE FROM persona WHERE id = (SELECT idpersona FROM representante WHERE id = '$idrepresentante')";

		return ejecutarConsulta($sql);
	}

	public function verificar_representante_idpersona($idpersona, $idestudiante)
	{
		$sql = "SELECT * FROM inscripcion WHERE idrepresentante = (SELECT id FROM representante WHERE idpersona = '$idpersona') AND idestudiante != '$idestudiante' ";
		return ejecutarConsulta($sql);
	}

	public function verificar_padre($idpersona, $idestudiante)
	{
		$sql = "SELECT * FROM estudiante WHERE idmadre = '$idpersona' OR idmadre = '$idpersona' AND id != '$idestudiante'";
		return ejecutarConsulta($sql);
	}

	public function verificar_padre_personal($idpersona)
	{
		$sql = "SELECT * FROM personal WHERE idpersona = '$idpersona' ";
		return ejecutarConsulta($sql);
	}

	function eliminar_persona_padre($idpersona)
	{
		$sql = "DELETE FROM persona WHERE id = '$idpersona'";

		return ejecutarConsulta($sql);
	}

	#Método para obtener los datos de la institucion
	function traerdatosinstitucion()
	{
	  $sql = "SELECT * FROM institucion";
	  return ejecutarConsultaSimpleFila($sql);
	}

	public function traerdatosdirector()
	{
	$sql = "SELECT p_d.cargo, perso.p_nombre, perso.p_apellido, perso.genero, perso.cedula  FROM personal_directivo p_d INNER JOIN personal pernal ON pernal.id = p_d.idpersonal INNER JOIN persona perso ON perso.id = pernal.idpersona WHERE p_d.cargo = 'director' AND p_d.estatus = 1";
	return ejecutarConsultaSimpleFila($sql);
	}

	function traerpersonaestudiante($idpersona, $idestudiante)
	{
		$sql = "SELECT peres.p_nombre AS p_nombre_estudiante, peres.s_nombre AS s_nombre_estudiante, peres.p_apellido AS p_apellido_estudiante, peres.s_apellido AS s_apellido_estudiante, muni.municipio, esta.estado, peres.f_nac, peres.genero, peres.cedula FROM persona peres INNER JOIN lugar_nacimiento lu_na ON lu_na.idestudiante = '$idestudiante' INNER JOIN parroquia parro ON parro.id = lu_na.idparroquia INNER JOIN municipio muni ON muni.id = parro.idmunicipio INNER JOIN estado esta ON esta.id = muni.idestado WHERE peres.id = '$idpersona'";

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para traer el id del período escolar activo
	function consultarperiodo()
	{
	  $sql = "SELECT id, periodo FROM periodo_escolar WHERE estatus = 'Activo'";
	  return ejecutarConsultaSimpleFila($sql);
	}

	function actualizar_cupo_planificacion($id_ultima_planificacion, $estatus){
		if ($estatus == 'CURSANDO') {
			
			$sql = "UPDATE planificacion SET cupo_disponible = cupo_disponible + 1 WHERE id = '$id_ultima_planificacion'";

			return ejecutarConsulta($sql);
		}
	}

}