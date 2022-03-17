<?php

#Se incluye la conexión a la base de datos
require_once dirname(__DIR__) . '/../config/conexion.php';

/**
 * Modelo de inscripción 
 */
class Inscripcion
{

  #Constructor de la clase
  public function __construct()
  {
  }

  public function inscribir($idperiodo_escolar, $idplanificacion, $idestudiante, $idrepresentante, $parentesco, $plantel_procedencia, $observaciones, $estatus)
  {
    $sql = "INSERT INTO inscripcion (id, idperiodo_escolar, idplanificacion, idestudiante, idrepresentante, parentesco, plantel_procedencia, observaciones, fecha_inscripcion, estatus) VALUES(NULL, $idperiodo_escolar, $idplanificacion, $idestudiante, $idrepresentante, '$parentesco',  '$plantel_procedencia', '$observaciones', CURDATE(), '$estatus') ";

    return ejecutarConsulta_retornarID($sql);
  }

  public function registrar_documentos_consignados($idinscripcion, $fotocopia_cedula_madre, $fotocopia_cedula_padre, $fotocopia_cedula_representante, $fotos_representante, $fotocopia_partida_nacimiento, $fotocopia_cedula_estudiante, $fotocopia_constancia_vacunas, $fotos_estudiante, $boleta_promocion, $constancia_buena_conducta, $informe_descriptivo)
  {
    $sql = "INSERT INTO documentos_consignados (id, idinscripcion, fotocopia_cedula_madre, fotocopia_cedula_padre, fotocopia_cedula_representante, fotos_representante, fotocopia_partida_nacimiento, fotocopia_cedula_estudiante, fotocopia_constancia_vacunas, fotos_estudiante, boleta_promocion, constancia_buena_conducta, informe_descriptivo) VALUES (NULL, '$idinscripcion', '$fotocopia_cedula_madre', '$fotocopia_cedula_padre', '$fotocopia_cedula_representante', '$fotos_representante', '$fotocopia_partida_nacimiento', '$fotocopia_cedula_estudiante', '$fotocopia_constancia_vacunas', '$fotos_estudiante', '$boleta_promocion', '$constancia_buena_conducta', '$informe_descriptivo')";

    return ejecutarConsulta($sql);
  }

  public function editar_documentos_consignados($idinscripcion, $fotocopia_cedula_madre, $fotocopia_cedula_padre, $fotocopia_cedula_representante, $fotos_representante, $fotocopia_partida_nacimiento, $fotocopia_cedula_estudiante, $fotocopia_constancia_vacunas, $fotos_estudiante, $boleta_promocion, $constancia_buena_conducta, $informe_descriptivo)
  {
    $sql = "UPDATE documentos_consignados SET fotocopia_cedula_madre = '$fotocopia_cedula_madre', fotocopia_cedula_padre = '$fotocopia_cedula_padre', fotocopia_cedula_representante = '$fotocopia_cedula_representante', fotos_representante = '$fotos_representante', fotocopia_partida_nacimiento = '$fotocopia_partida_nacimiento', fotocopia_cedula_estudiante = '$fotocopia_cedula_estudiante', fotocopia_constancia_vacunas = '$fotocopia_constancia_vacunas', fotos_estudiante = '$fotos_estudiante', boleta_promocion = '$boleta_promocion', constancia_buena_conducta = '$constancia_buena_conducta', informe_descriptivo = '$informe_descriptivo' WHERE idinscripcion = '$idinscripcion'";

    return ejecutarConsulta($sql);
  }

  #Método para insertar una persona y devolver el id
  function insertar_persona($cedula = NULL, $p_nombre = NULL, $s_nombre = NULL, $p_apellido = NULL, $s_apellido = NULL, $genero = NULL, $f_nac = NULL)
  {
    if ($f_nac == NULL)
      $sql = "INSERT INTO persona (cedula, p_nombre, s_nombre, p_apellido, s_apellido, genero, f_creacion) VALUES('$cedula', '$p_nombre', '$s_nombre', '$p_apellido', '$s_apellido', '$genero', NOW())";
    else
      $sql = "INSERT INTO persona (cedula, p_nombre, s_nombre, p_apellido, s_apellido, genero, f_nac, f_creacion) VALUES('$cedula', '$p_nombre', '$s_nombre', '$p_apellido', '$s_apellido', '$genero', '$f_nac' , NOW())";


    return ejecutarConsulta_retornarID($sql);
  }

  #Método para editar una persona
  function editar_persona($id, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido)
  {
    $sql = "UPDATE persona SET cedula='$cedula', p_nombre = '$p_nombre', s_nombre = '$s_nombre', p_apellido = '$p_apellido', s_apellido = '$s_apellido' WHERE id = '$id'";

    return ejecutarConsulta($sql);
  }

  #Método para editar una persona
  function editar_persona_estudiante($id, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac)
  {
    $sql = "UPDATE persona SET cedula='$cedula', p_nombre = '$p_nombre', s_nombre = '$s_nombre', p_apellido = '$p_apellido', s_apellido = '$s_apellido', genero = '$genero', f_nac = '$f_nac' WHERE id = '$id'";

    return ejecutarConsulta($sql);
  }

  #Método para verificar si una persona tiene un registro en dirección residencial
  function verificar_direccion_residencial($idpersona)
  {
    $sql = "SELECT * FROM direccion WHERE idpersona = '$idpersona'";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para insertar la dirección residencial
  function insertar_direccion_residencial($idpersona, $idparroquia, $direccion)
  {
    $sql = "INSERT INTO direccion (id, idpersona, idparroquia, direccion) VALUES(NULL, '$idpersona', $idparroquia, '$direccion')";

    return ejecutarConsulta($sql);
  }

  #Método para editar la dirección residencial
  function editar_direccion_residencial($idpersona, $direccion)
  {
    $sql = "UPDATE direccion SET direccion = '$direccion' WHERE idpersona = '$idpersona'";

    return ejecutarConsulta($sql);
  }

  function verificar_lugar_nacimiento($idestudiante)
  {
    $sql = "SELECT * FROM lugar_nacimiento WHERE idestudiante = '$idestudiante'";

    return ejecutarConsultaSimpleFila($sql);
  }

  function editar_lugar_nacimiento($idestudiante, $idparroquia)
  {
    $sql = "UPDATE lugar_nacimiento SET idparroquia = '$idparroquia' WHERE idestudiante = '$idestudiante'";

    return ejecutarConsulta($sql);
  }

  function verificar_direccion_trabajo($idpersona)
  {
    $sql = "SELECT * FROM direccion_trabajo WHERE idpersona = '$idpersona'";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para insertar la dirección de trabajo
  function insertar_direccion_trabajo($idpersona, $idparroquia, $direccion)
  {
    $sql = "INSERT INTO direccion_trabajo (id, idpersona, idparroquia, direccion) VALUES(NULL, '$idpersona', $idparroquia, '$direccion')";

    return ejecutarConsulta($sql);
  }

  #Método para editar registros
  function editar_direccion_trabajo($idpersona, $direccion)
  {
    $sql = "UPDATE direccion_trabajo SET direccion = '$direccion' WHERE idpersona = '$idpersona'";

    return ejecutarConsulta($sql);
  }

  #Método para insertar los teléfonos
  function insertar_telefono($idpersona, $telefono, $tipo)
  {
    $sql = "INSERT INTO telefono (idpersona, telefono, tipo) VALUES('$idpersona', '$telefono', '$tipo')";

    return ejecutarConsulta($sql);
  }

  #Método para eliminar los teléfonos
  function eliminar_telefono($idpersona, $tipo)
  {
    $sql = "DELETE FROM telefono WHERE idpersona = '$idpersona' AND tipo = '$tipo'";

    return ejecutarConsulta($sql);
  }

  #Método para insertar los representantes
  function insertar_representante($idpersona, $instruccion, $oficio)
  {
    $sql = "INSERT INTO representante (id, idpersona, instruccion, oficio, estatus) VALUES(NULL, '$idpersona', '$instruccion', '$oficio', '1')";

    return ejecutarConsulta_retornarID($sql);
  }

  #Método para editar registros
  function editar_representante($id, $oficio)
  {
    $sql = "UPDATE representante SET oficio = '$oficio' WHERE id = '$id'";

    return ejecutarConsulta($sql);
  }

  #Método para insertar registros
  function insertar_estudiante($idpersona, $idmadre, $idpadre, $parto_multiple, $orden_nacimiento, $estatus)
  {
    if (!empty($idpadre)) {
      $sql = "INSERT INTO estudiante (idpersona, idmadre, idpadre, parto_multiple, orden_nacimiento, estatus) VALUES('$idpersona', '$idmadre', '$idpadre', '$parto_multiple', '$orden_nacimiento', '$estatus')";
    } else {
      $sql = "INSERT INTO estudiante (idpersona, idmadre, parto_multiple, orden_nacimiento, estatus) VALUES('$idpersona', '$idmadre', '$parto_multiple', '$orden_nacimiento', '$estatus')";
    }

    return ejecutarConsulta_retornarID($sql);
  }

  #Método para editar registros
  function editar_estudiante($idpersona, $idmadre, $idpadre, $parto_multiple, $orden_nacimiento, $estatus)
  {

    if (!empty($idpadre)) {
      $sql = "UPDATE estudiante SET idmadre = '$idmadre', idpadre = '$idpadre', parto_multiple = '$parto_multiple', orden_nacimiento = '$orden_nacimiento', estatus = '$estatus' WHERE idpersona = '$idpersona'";
    } else {
      $sql = "UPDATE estudiante SET idmadre = '$idmadre', parto_multiple = '$parto_multiple', orden_nacimiento = '$orden_nacimiento', estatus = '$estatus' WHERE idpersona = '$idpersona'";
    }

    // var_dump($sql);
    // die;
    return ejecutarConsulta($sql);
  }

  #Método para insertar lugar de nacimiento
  function insertar_lugar_nacimiento($idestudiante, $idparroquia)
  {
    $sql = "INSERT INTO lugar_nacimiento (id, idestudiante, idparroquia) VALUES(NULL, '$idestudiante', '$idparroquia')";

    return ejecutarConsulta($sql);
  }

  #Método para obtener el id de la persona con el id del representante
  function idpersona($idrepresentante)
  {
    $sql = "SELECT idpersona FROM representante WHERE id = '$idrepresentante'";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para editar registros
  function editar($id, $idgrado, $idseccion, $idambiente, $iddocente, $cupo)
  {
    $sql = "UPDATE planificacion SET idgrado = '$idgrado', idseccion = '$idseccion', idambiente = '$idambiente', iddocente = '$iddocente', cupo = '$cupo' WHERE id = '$id'";

    return ejecutarConsulta($sql);
  }

  #Método para listar 
  function listarPlanificacionActiva($id_docente = null)
  {
    if ($id_docente != null)
      $sql = "SELECT p.*, pe.periodo, g.grado, s.seccion, a.ambiente, per.idpersona, persona.p_nombre, persona.p_apellido FROM planificacion p INNER JOIN periodo_escolar pe ON p.idperiodo_escolar = pe.id INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON s.id = p.idseccion INNER JOIN ambiente a ON a.id = p.idambiente INNER JOIN personal per ON per.id = p.iddocente INNER JOIN persona persona ON persona.id = per.idpersona WHERE p.estatus = 'Activo' AND p.iddocente = '$id_docente' ORDER BY g.grado, s.seccion";
    else
      $sql = "SELECT p.*, pe.periodo, g.grado, s.seccion, a.ambiente, per.idpersona, persona.p_nombre, persona.p_apellido FROM planificacion p INNER JOIN periodo_escolar pe ON p.idperiodo_escolar = pe.id INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON s.id = p.idseccion INNER JOIN ambiente a ON a.id = p.idambiente INNER JOIN personal per ON per.id = p.iddocente INNER JOIN persona persona ON persona.id = per.idpersona WHERE p.estatus = 'Activo' ORDER BY g.grado, s.seccion";

    return ejecutarConsulta($sql);
  }

  #Método para listar 
  function listarPlanificacionPlanificada($id_docente = null)
  {
    if ($id_docente != null)
      $sql = "SELECT p.*, pe.periodo, g.grado, s.seccion, a.ambiente, per.idpersona, persona.p_nombre, persona.p_apellido FROM planificacion p INNER JOIN periodo_escolar pe ON p.idperiodo_escolar = pe.id INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON s.id = p.idseccion INNER JOIN ambiente a ON a.id = p.idambiente INNER JOIN personal per ON per.id = p.iddocente INNER JOIN persona persona ON persona.id = per.idpersona WHERE p.id IN(SELECT id FROM planificacion WHERE estatus = 'Planificado') AND p.iddocente = '$id_docente' ORDER BY g.grado, s.seccion";
    else
      $sql = "SELECT p.*, pe.periodo, g.grado, s.seccion, a.ambiente, per.idpersona, persona.p_nombre, persona.p_apellido FROM planificacion p INNER JOIN periodo_escolar pe ON p.idperiodo_escolar = pe.id INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON s.id = p.idseccion INNER JOIN ambiente a ON a.id = p.idambiente INNER JOIN personal per ON per.id = p.iddocente INNER JOIN persona persona ON persona.id = per.idpersona WHERE p.id IN(SELECT id FROM planificacion WHERE estatus = 'Planificado') ORDER BY g.grado, s.seccion";

    return ejecutarConsulta($sql);
  }

  #Método para mostrar los estudiantes inscritos en una planificación
  function mostrar($idplanificacion)
  {
    $sql = "SELECT  est.id, per.cedula, per.p_nombre, per.s_nombre, per.p_apellido, per.s_apellido, per.id AS idpersona FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id  INNER JOIN persona per ON est.idpersona = per.id WHERE idplanificacion = '$idplanificacion'";

    return ejecutarConsulta($sql);
  }

  #Método para eliminar planificación
  function eliminar($idplanificacion)
  {
    $sql = "DELETE FROM planificacion WHERE id = $idplanificacion";

    return ejecutarConsulta($sql);
  }

  #Método para traer los estudiantes inscritos
  function comprobarinscripcion($cedula)
  {
    $sql = "SELECT e.id FROM persona p INNER JOIN estudiante e ON e.idpersona = p.id INNER JOIN inscripcion i ON i.idestudiante = e.id WHERE p.cedula = '$cedula' AND e.estatus = 'INSCRITO';";
    // $sql = "SELECT est.id as idE, per.cedula as cedulaE, per.p_nombre as nombreE, per.p_apellido as apellidoE FROM estudiante as est INNER JOIN persona as per ON per.id = est.idpersona WHERE est.id NOT IN(SELECT idestudiante FROM inscripcion WHERE idperiodo_escolar = (SELECT id FROM periodo_escolar WHERE estatus = 1))";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para comprobar si existe el estudiante
  function comprobarestudiante($cedula)
  {
    $sql = "SELECT e.id FROM estudiante e INNER JOIN persona p ON e.idpersona = p.id WHERE p.cedula = '$cedula'";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para comprobar si existe el representante
  function comprobarrepresentante($cedula, $genero)
  {
    if ($genero)
      $sql = "SELECT r.id, r.idpersona, r.instruccion, r.oficio FROM representante r INNER JOIN persona p ON r.idpersona = p.id WHERE p.cedula = '$cedula' AND p.genero = '$genero' AND r.estatus = 1";
    else
      $sql = "SELECT r.id, r.idpersona, r.instruccion, r.oficio FROM representante r INNER JOIN persona p ON r.idpersona = p.id WHERE p.cedula = '$cedula' AND r.estatus = 1";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para comprobar si existe la persona
  function comprobarpersona($cedula, $genero)
  {
    if ($genero)
      $sql = "SELECT p.id, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, d.direccion as direccion_residencia, (SELECT telefono FROM telefono WHERE idpersona = p.id AND tipo = 'M') as celular, (SELECT direccion FROM direccion_trabajo WHERE idpersona = p.id) as direccion_trabajo FROM persona p  LEFT JOIN direccion d ON d.idpersona = p.id WHERE p.cedula = '$cedula' AND p.genero = '$genero'";
    else
      $sql = "SELECT p.id, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, p.genero, d.direccion as direccion_residencia, (SELECT telefono FROM telefono WHERE idpersona = p.id AND tipo = 'M') as celular, (SELECT direccion FROM direccion_trabajo WHERE idpersona = p.id) as direccion_trabajo FROM persona p  LEFT JOIN direccion d ON d.idpersona = p.id WHERE p.cedula = '$cedula'";

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

  #Método para traer el id del período escolar activo
  function consultarperiodo()
  {
    $sql = "SELECT id, periodo FROM periodo_escolar WHERE estatus = 'Activo'";
    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para mostrar las planificaciones con el formato de la vista de inscripción
  public function traerplanificaciones($id_docente = null)
  {
    if ($id_docente != null)
      $sql = "SELECT pla.id, gra.grado, sec.seccion, pla.cupo_disponible FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion WHERE pla.estatus = 'Activo' AND pla.iddocente = '$id_docente' AND pla.cupo_disponible > 0  ORDER BY gra.grado, sec.seccion";
    else
      $sql = "SELECT pla.id, gra.grado, sec.seccion, pla.cupo_disponible FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion WHERE pla.estatus = 'Activo' AND pla.cupo_disponible > 0 ORDER BY gra.grado, sec.seccion";
    return ejecutarConsulta($sql);
  }

  #Método para comprobar los cupos disponibles de una planificación
  function verificarcupo($idplanificacion, $tipo)
  {
    $sql = "SELECT $tipo FROM planificacion WHERE id = '$idplanificacion'";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para restar un cupo a la planificación
  function restarcupo($idplanificacion, $cupo_disponible)
  {
    $sql = "UPDATE planificacion SET cupo_disponible = $cupo_disponible WHERE id = '$idplanificacion'";
    return ejecutarConsulta($sql);
  }

  #Método para traer todos los estudiantes que estén esperando a ser inscritos
  public function listadoinscripcionregular()
  {
    // $sql = "SELECT  DISTINCT ins.idestudiante, ins.id AS idinscripcion, est.id, per.cedula, per.p_nombre, per.p_apellido, ins.estatus, gra.grado, sec.seccion, p_e.periodo FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id  INNER JOIN persona per ON est.idpersona = per.id INNER JOIN planificacion pla ON ins.idplanificacion = pla.id INNER JOIN grado gra ON pla.idgrado = gra.id INNER JOIN seccion sec ON pla.idseccion = sec.id INNER JOIN periodo_escolar p_e ON pla.idperiodo_escolar = p_e.id WHERE ins.estatus = 'PROMOVIDO' OR ins.estatus = 'REPITE' AND est.estatus = 'INSCRITO' GROUP BY ins.idestudiante ORDER BY ins.id DESC;";

    // SELECT  est.id, per.cedula, per.p_nombre, per.p_apellido, ins.estatus, gra.grado, sec.seccion FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id  INNER JOIN persona per ON est.idpersona = per.id INNER JOIN planificacion pla ON ins.idplanificacion = pla.id INNER JOIN grado gra ON pla.idgrado = gra.id INNER JOIN seccion sec ON pla.idseccion = sec.id WHERE ins.estatus = 'PROMOVIDO' OR ins.estatus = 'REPITE'

    $sql = "SELECT ins.id AS idinscripcion, ins.idestudiante, per.cedula, per.p_nombre, per.p_apellido,  ins.estatus, gra.grado, sec.seccion, p_e.periodo FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id  INNER JOIN persona per ON est.idpersona = per.id INNER JOIN planificacion pla ON ins.idplanificacion = pla.id INNER JOIN grado gra ON pla.idgrado = gra.id INNER JOIN seccion sec ON pla.idseccion = sec.id INNER JOIN periodo_escolar p_e ON pla.idperiodo_escolar = p_e.id WHERE ins.id IN (SELECT MAX(id) FROM inscripcion WHERE idestudiante = ins.idestudiante) AND est.estatus = 'INSCRITO'";

    return ejecutarConsulta($sql);
  }

  #Método para traer los datos del representante de una inscirpción regular
  public function traerrepresentanteregular($idinscripcionregular)
  {
    $sql = "SELECT per.id AS idpersona,  rep.id AS idrepresentante, ins.parentesco, rep.oficio, per.cedula, per.p_nombre, per.s_nombre, per.p_apellido, per.s_apellido, per.genero, d.direccion as direccion_residencia, (SELECT telefono FROM telefono WHERE idpersona = per.id AND tipo = 'M') as celular, (SELECT direccion FROM direccion_trabajo WHERE idpersona = per.id) as direccion_trabajo FROM inscripcion ins INNER JOIN representante rep ON ins.idrepresentante = rep.id INNER JOIN persona per ON rep.idpersona = per.id LEFT JOIN direccion d ON d.idpersona = per.id WHERE ins.id = '$idinscripcionregular'";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para traer periodo de la inscripción
  function traerperiodoinscripcion($idinscripcionregular)
  {
    $sql = "SELECT per.periodo FROM inscripcion ins INNER JOIN periodo_escolar per ON ins.idperiodo_escolar = per.id WHERE ins.id = '$idinscripcionregular'";
    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para traer el siguiente período escolar según la última inscripción
  function traersiguienteperiodo($siguiente_periodo)
  {
    $sql = "SELECT * FROM periodo_escolar WHERE periodo = '$siguiente_periodo'";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para traer la planificación que le corresponda al estudiante en inscripción regular
  function traerplanificacionregular($idsiguienteperiodo, $grado)
  {
    $sql = "SELECT pla.id, gra.grado, sec.seccion, pla.cupo_disponible, per.p_nombre, per.p_apellido FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion INNER JOIN personal perl ON pla.iddocente = perl.id INNER JOIN persona per ON perl.idpersona = per.id WHERE pla.idperiodo_escolar = '$idsiguienteperiodo' AND pla.idgrado = (SELECT id FROM grado WHERE grado = '$grado') AND pla.cupo_disponible > 0";
    return ejecutarConsulta($sql);
  }

  #Método para obtener los datos de la institucion
  function traerdatosinstitucion()
  {
    $sql = "SELECT * FROM institucion";
    return ejecutarConsultaSimpleFila($sql);
  }

  public function traerpersonal($idusuario)
  {
    $sql = "SELECT c.id FROM usuario a INNER JOIN persona b ON a.idpersona = b.id INNER JOIN personal c ON c.idpersona = b.id WHERE a.id = '$idusuario'";
    return ejecutarConsultaSimpleFila($sql);
  }

  public function traerdatosdirector()
  {
    $sql = "SELECT p_d.cargo, perso.p_nombre, perso.p_apellido, perso.genero, perso.cedula  FROM personal_directivo p_d INNER JOIN personal pernal ON pernal.id = p_d.idpersonal INNER JOIN persona perso ON perso.id = pernal.idpersona WHERE p_d.cargo = 'director' AND p_d.estatus = 1";
    return ejecutarConsultaSimpleFila($sql);
  }

  public function traerdocumentosconsignados($idinscripcion)
  {
    $sql = "SELECT *  FROM documentos_consignados WHERE idinscripcion = '$idinscripcion'";

    return ejecutarConsultaSimpleFila($sql);
  }

  #Método para mostrar los estudiantes inscritos en una planificación para el reporte ins_inicial
  function estudianteplanificacion($idplanificacion)
  {
    $sql = "SELECT  est.id, per.cedula, per.p_nombre, per.s_nombre, per.p_apellido, per.s_apellido, per.genero, per.f_nac, muni.municipio, per_repre.p_nombre AS p_nombre_representante, per_repre.p_apellido AS p_apellido_representante, per_repre.cedula AS cedula_repre, direc.direccion, tele.telefono FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id  INNER JOIN persona per ON est.idpersona = per.id LEFT JOIN lugar_nacimiento lug_nac ON est.id = lug_nac.idestudiante LEFT JOIN parroquia parro ON parro.id = lug_nac.idparroquia LEFT JOIN municipio muni ON muni.id = parro.idmunicipio INNER JOIN representante repre ON repre.id = ins.idrepresentante LEFT JOIN persona per_repre ON per_repre.id = repre.idpersona left JOIN direccion direc ON direc.idpersona = per_repre.id left join telefono tele ON tele.idpersona = per_repre.id  WHERE idplanificacion = '$idplanificacion' ORDER BY per.p_apellido ASC;";

    return ejecutarConsulta($sql);
  }
}
