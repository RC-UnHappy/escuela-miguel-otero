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
  public function traerplanificaciones($idperiodo_escolar)
  {
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
	
}


