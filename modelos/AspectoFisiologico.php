<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Aspecto Fisiológico
 */
class AspectoFisiologico 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idplanificacion, $idestudiante ,$peso, $talla, $todas_vacunas, $alergia, $c, $alimentos, $utiles)
	{
    $sql = "INSERT INTO aspecto_fisiologicos (id, idplanificacion, idestudiante ,peso, talla, todas_vacunas,alergia, c, alimentos, utiles) VALUES(NULL, '$idplanificacion', '$idestudiante', '$peso', '$talla', '$todas_vacunas', '$alergia', '$c', '$alimentos', '$utiles')";

    return ejecutarConsulta_retornarID($sql);

  }
  
  #Método para listar 
	function listar($idplanificacion)
	{
      $sql = "SELECT as_fi.id, est.id AS idestudiante, peres.p_nombre, peres.s_nombre, peres.p_apellido, peres.s_apellido, peres.f_nac, peres.genero, as_fi.peso, as_fi.talla, as_fi.todas_vacunas, as_fi.alergia, as_fi.c, as_fi.alimentos, as_fi.utiles, GROUP_CONCAT(DISTINCT di_fu.diversidad) AS diversidades_funcionales, GROUP_CONCAT(DISTINCT enf.enfermedad) AS enfermedades FROM aspecto_fisiologicos as_fi INNER JOIN estudiante est ON as_fi.idestudiante = est.id INNER JOIN persona peres ON est.idpersona = peres.id LEFT JOIN diversidad_funcionals di_fu ON di_fu.idaspecto_fisiologico = as_fi.id LEFT JOIN enfermedads enf ON  enf.idaspecto_fisiologico = as_fi.id WHERE as_fi.idplanificacion = '$idplanificacion' GROUP BY est.id";

		return ejecutarConsulta($sql);
  }

	#Método para editar registros
	function editar($idaspectofisiologico, $peso, $talla, $todas_vacunas, $alergia, $c, $alimentos, $utiles)
	{
		$sql = "UPDATE aspecto_fisiologicos SET peso = '$peso', talla = '$talla', todas_vacunas = '$todas_vacunas', alergia = '$alergia', c = '$c', alimentos = '$alimentos', utiles = '$utiles' WHERE id = '$idaspectofisiologico'";

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
      $sql = "SELECT pla.id, gra.grado, sec.seccion, p.p_nombre, p.p_apellido FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona p ON per.idpersona = p.id WHERE pla.estatus = 'Activo' AND pla.idperiodo_escolar = '$idperiodo_escolar'";
      return ejecutarConsulta($sql);
  }

  #Método para mostrar los estudiantes de una planificación
  public function traerestudiantes($idplanificacion)
  {
    // $sql = "SELECT ins.idestudiante, per.p_nombre, per.s_nombre, per.p_apellido, per.s_apellido FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id INNER JOIN persona per ON est.idpersona = per.id  WHERE ins.idplanificacion = '$idplanificacion' AND ins.id NOT IN(SELECT idinscripcion FROM aspecto_fisiologicos WHERE idinscripcion = ins.id)";

    $sql = "SELECT ins.idestudiante, per.p_nombre, per.s_nombre, per.p_apellido, per.s_apellido FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id INNER JOIN persona per ON est.idpersona = per.id WHERE ins.idplanificacion = '$idplanificacion' AND est.id NOT IN (SELECT idestudiante FROM aspecto_fisiologicos WHERE idplanificacion = '$idplanificacion')";
    return ejecutarConsulta($sql);
  }

  public function traeridinscripcion($idplanificacion, $idestudiante)
  {
    $sql = "SELECT id FROM inscripcion WHERE idplanificacion = '$idplanificacion' AND idestudiante = '$idestudiante'";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para mostrar un registro de aspecto fisiológico
	function mostrar($idaspectofisiologico)
	{
    $sql = "SELECT as_fi.*, peres.p_nombre as p_nombre_estudiante, peres.s_nombre as s_nombre_estudiante, peres.p_apellido as p_apellido_estudiante, peres.s_apellido as s_apellido_estudiante, gra.grado, sec.seccion, p.p_nombre, p.p_apellido, GROUP_CONCAT(DISTINCT di_fu.diversidad) as diversidades_funcionales, GROUP_CONCAT(DISTINCT enf.enfermedad) as enfermedades FROM aspecto_fisiologicos as_fi INNER JOIN estudiante est ON as_fi.idestudiante = est.id INNER JOIN persona peres ON est.idpersona = peres.id LEFT JOIN diversidad_funcionals di_fu ON di_fu.idaspecto_fisiologico = '$idaspectofisiologico' LEFT JOIN enfermedads enf ON enf.idaspecto_fisiologico = '$idaspectofisiologico' INNER JOIN planificacion pla ON as_fi.idplanificacion = pla.id INNER JOIN grado gra ON pla.idgrado = gra.id INNER JOIN seccion sec ON pla.idseccion = sec.id INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona p ON per.idpersona = p.id WHERE as_fi.id = '$idaspectofisiologico'";

		return ejecutarConsultaSimpleFila($sql);
  }
  
  public function datos_reporte($idplanificacion)
  {
    $sql = "SELECT as_fi.id, est.id AS idestudiante, peres.p_nombre, peres.s_nombre, peres.p_apellido, peres.s_apellido, peres.f_nac, peres.genero, as_fi.peso, as_fi.talla, as_fi.todas_vacunas, as_fi.alergia, as_fi.c, as_fi.alimentos, as_fi.utiles, GROUP_CONCAT(DISTINCT di_fu.diversidad) AS diversidades_funcionales, GROUP_CONCAT(DISTINCT enf.enfermedad) AS enfermedades FROM aspecto_fisiologicos as_fi INNER JOIN estudiante est ON as_fi.idestudiante = est.id INNER JOIN persona peres ON est.idpersona = peres.id LEFT JOIN diversidad_funcionals di_fu ON di_fu.idaspecto_fisiologico = as_fi.id LEFT JOIN enfermedads enf ON enf.idaspecto_fisiologico = as_fi.id WHERE as_fi.idplanificacion = '$idplanificacion' GROUP BY est.id";

   return ejecutarConsulta($sql);
  }

  public function datos_planificacion($idplanificacion)
  {
    $sql = "SELECT pla.id, gra.grado, sec.seccion, p.p_nombre, p.p_apellido, p_e.periodo FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona p ON per.idpersona = p.id INNER JOIN periodo_escolar p_e ON pla.idperiodo_escolar = p_e.id WHERE pla.id = '$idplanificacion'";
   return ejecutarConsultaSimpleFila($sql);
  }

}