<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de BoletinFinal
 */
class BoletinFinal
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}
 
	#Método para insertar boletin final
	function insertar($idplanificacion, $idestudiantes, $idliteral, $descriptivo_final)
	{
    $sql = "INSERT INTO boletin_final (idplanificacion, idestudiante, idexpresion_literal, descriptivo_final) VALUES('$idplanificacion', '$idestudiantes', '$idliteral', '$descriptivo_final')";

    return ejecutarConsulta($sql);
  }

  #Método para editar boletin final
  function editar($idboletinfinal, $idliteral, $descriptivo_final)
  {
    $sql = "UPDATE boletin_final SET idexpresion_literal = '$idliteral', descriptivo_final = '$descriptivo_final' WHERE id = '$idboletinfinal'";
    
    return ejecutarConsulta($sql);
  }

	#Método para listar 
	function listar($idplanificacion)
	{
      $sql = "SELECT est.id as idestudiante, peres.p_nombre, peres.p_apellido, peres.cedula, lit.literal, bof.descriptivo_final, bof.id FROM boletin_final bof INNER JOIN estudiante est ON bof.idestudiante = est.id INNER JOIN persona peres ON est.idpersona = peres.id INNER JOIN expresion_literal lit ON bof.idexpresion_literal = lit.id WHERE bof.idplanificacion = '$idplanificacion'";

		return ejecutarConsulta($sql);
  }


	function seleccionar_lapsos_finalizados($idperiodo_escolar)
  {
    $sql = "SELECT * FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar' AND estatus = 'Finalizado'";
		return ejecutarConsulta($sql);
  }

	#Método para traer el id del período escolar activo
	function consultarperiodo()
	{
		$sql = "SELECT id, periodo FROM periodo_escolar WHERE estatus = 'Activo'";
		return ejecutarConsultaSimpleFila($sql);
	}

  #Método para mostrar las planificaciones activas
  public function traerplanificaciones($idperiodo_escolar, $id_docente = null)
  {
    if ($id_docente != null) 
      $sql = "SELECT pla.id, gra.grado, sec.seccion, p.p_nombre, p.p_apellido, p.cedula FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona p ON per.idpersona = p.id WHERE pla.estatus = 'Activo' AND pla.iddocente = '$id_docente' AND (SELECT COUNT(id) FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar') = (SELECT COUNT(id) FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar' AND estatus = 'Finalizado')";
    else
      $sql = "SELECT pla.id, gra.grado, sec.seccion, p.p_nombre, p.p_apellido FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona p ON per.idpersona = p.id WHERE pla.estatus = 'Activo' AND (SELECT COUNT(id) FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar') = (SELECT COUNT(id) FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar' AND estatus = 'Finalizado')";

    return ejecutarConsulta($sql);
  }

  #Método para mostrar los estudiantes de una planificación
  public function traerestudiantes($idplanificacion)
  {
    $sql = "SELECT ins.idestudiante, per.p_nombre, per.s_nombre, per.p_apellido, per.s_apellido FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id INNER JOIN persona per ON est.idpersona = per.id  WHERE ins.idplanificacion = '$idplanificacion' AND est.id NOT IN(SELECT idestudiante FROM boletin_final WHERE idplanificacion = '$idplanificacion')";
    return ejecutarConsulta($sql);
  }

  #Método para traer las notas literales
  public function traerliterales()
  {
    $sql = "SELECT * FROM expresion_literal WHERE estatus = 1 ORDER BY literal";
    
    return ejecutarConsulta($sql);
  }

  public function datos_reporte($idplanificacion, $idestudiante)
  {
    $sql = "SELECT gra.grado, sec.seccion, personaes.cedula, personaes.p_nombre as p_nombre_estudiante, personaes.s_nombre as s_nombre_estudiante, personaes.p_apellido as p_apellido_estudiante, personaes.s_apellido as s_apellido_estudiante, personaes.f_nac ,per_e.periodo, mun.municipio, esta.estado, bol_f.descriptivo_final, ex_li.literal, ex_li.interpretacion FROM planificacion pla INNER JOIN grado gra ON pla.idgrado = gra.id INNER JOIN seccion sec ON pla.idseccion = sec.id INNER JOIN periodo_escolar per_e ON pla.idperiodo_escolar = per_e.id INNER JOIN estudiante est ON est.id = '$idestudiante' INNER JOIN persona personaes ON est.idpersona = personaes.id INNER JOIN lugar_nacimiento l_n ON est.id = l_n.idestudiante INNER JOIN parroquia parro ON l_n.idparroquia = parro.id INNER JOIN municipio mun ON parro.idmunicipio = mun.id INNER JOIN estado esta ON mun.idestado = esta.id INNER JOIN boletin_final bol_f ON bol_f.idplanificacion = '$idplanificacion' AND bol_f.idestudiante = '$idestudiante' INNER JOIN  expresion_literal ex_li ON bol_f.idexpresion_literal = ex_li.id WHERE pla.id = '$idplanificacion'";

    return ejecutarConsultaSimpleFila($sql);
  }

  public function datos_institucion()
  {
    $sql = "SELECT * FROM institucion";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para mostrar un boletin final
	function mostrar($idboletinfinal)
	{
		$sql = "SELECT bof.*, peres.p_nombre as p_nombre_estudiante, peres.s_nombre as s_nombre_estudiante, peres.p_apellido as p_apellido_estudiante, peres.s_apellido as s_apellido_estudiante, gra.grado, sec.seccion, p.p_nombre, p.p_apellido FROM boletin_final bof INNER JOIN estudiante est ON bof.idestudiante = est.id INNER JOIN persona peres ON est.idpersona = peres.id INNER JOIN planificacion pla ON bof.idplanificacion = pla.id INNER JOIN grado gra ON pla.idgrado = gra.id INNER JOIN seccion sec ON pla.idseccion = sec.id INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona p ON per.idpersona = p.id WHERE bof.id = '$idboletinfinal'";
    
		return ejecutarConsultaSimpleFila($sql);
  }

  public function obtener_literal($idliteral)
  {
    $sql = "SELECT literal FROM expresion_literal WHERE id = '$idliteral'";
    return ejecutarConsultaSimpleFila($sql);
  }
  
  public function cambiar_estatus_inscripcion($idplanificacion, $idestudiante, $literal)
  {
    if ($literal == 'E') {
      $sql = "UPDATE inscripcion SET estatus = 'REPITE' WHERE idplanificacion = '$idplanificacion' AND idestudiante = '$idestudiante'";      
    }
    else {
      $sql = "UPDATE inscripcion SET estatus = 'PROMOVIDO' WHERE idplanificacion = '$idplanificacion' AND idestudiante = '$idestudiante'";
    }
    return ejecutarConsulta($sql);
  }

  public function traerpersonal($idusuario)
  {
    $sql = "SELECT c.id FROM usuario a INNER JOIN persona b ON a.idpersona = b.id INNER JOIN personal c ON c.idpersona = b.id WHERE a.id = '$idusuario'";
   return ejecutarConsultaSimpleFila($sql);
  }

  public function getPersonFromStudent($studentId)
  {
    $sql = "SELECT per.* FROM estudiante est INNER JOIN persona per ON est.idpersona = per.id WHERE est.id = '$studentId'";

    return ejecutarConsultaSimpleFila($sql);
  }

  function getRegistrations($studentId)
  {
    $sql = "SELECT ins.*, gra.grado, sec.seccion, p_e.periodo, perso.cedula AS cedula_docente, perso.p_nombre AS nombre_docente, perso.p_apellido AS apellido_docente, bo_fi.descriptivo_final, ex_li.literal, peres.cedula AS cedula_estudiante, peres.p_nombre AS p_nombre_estudiante, peres.s_nombre AS s_nombre_estudiante, peres.p_apellido AS p_apellido_estudiante, peres.s_apellido AS s_apellido_estudiante, peres.f_nac AS f_nac_estudiante, peres.genero AS genero_estudiante, muni.municipio, (SELECT turno FROM institucion) AS turno, estu.idmadre, estu.idpadre FROM inscripcion ins INNER JOIN planificacion pla ON pla.id = ins.idplanificacion INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = pla.idseccion INNER JOIN periodo_escolar p_e ON p_e.id = pla.idperiodo_escolar INNER JOIN personal pernal ON pernal.id = pla.iddocente INNER JOIN persona perso ON perso.id = pernal.idpersona INNER JOIN estudiante estu ON ins.idestudiante = estu.id INNER JOIN persona peres ON estu.idpersona = peres.id INNER JOIN lugar_nacimiento lu_na ON lu_na.idestudiante = estu.id INNER JOIN parroquia parro ON parro.id = lu_na.idparroquia INNER JOIN municipio muni ON muni.id = parro.idmunicipio LEFT JOIN boletin_final bo_fi ON bo_fi.idplanificacion = ins.idplanificacion AND bo_fi.idestudiante = ins.idestudiante LEFT JOIN expresion_literal ex_li ON ex_li.id = bo_fi.idexpresion_literal  WHERE ins.idestudiante = '$studentId'";

    return ejecutarConsulta($sql);
  }

  function retire($periodo_escolar, $turno, $grado, $seccion, $cedula_docente, $nombre_docente, $apellido_docente, $cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante, $fecha_nacimiento_estudiante, $lugar_nacimiento_estudiante, $sexo_estudiante, $literal, $observaciones, $estatus)
  {

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

  function eliminar($idpersona)
  {
    $sql = "DELETE FROM persona WHERE id = '$idpersona'";

    return ejecutarConsulta($sql);
  }

  public function getSchedule($scheduleId)
  {
    $sql = "SELECT pla.*, gra.grado FROM planificacion pla INNER JOIN grado gra ON pla.idgrado = gra.id WHERE pla.id = '$scheduleId'";

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

	
}


