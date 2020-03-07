<?php

#Se incluye la conexión a la base de datos
require_once '../../config/conexion.php';

/**
 * Modelo de inscripción inicial
 */
class Inicial
{

  #Constructor de la clase
  public function __construct()
  { }

  public function inscribir($idperiodo_escolar, $idplanificacion, $idestudiante, $idrepresentante, $parentesco, $plantel_procedencia, $repite, $observaciones, $estatus)
  {
    $sql = "INSERT INTO inscripcion (id, idperiodo_escolar, idplanificacion, idestudiante, idrepresentante, parentesco, plantel_procedencia, repite, observaciones, fecha_inscripcion, estatus) VALUES(NULL, $idperiodo_escolar, $idplanificacion, $idestudiante, $idrepresentante, $parentesco,  $plantel_procedencia, $repite, $observaciones, CURDATE(), $estatus) ";

    return ejecutarConsulta_retornarID($sql);
  }

  public function registrar_documentos_consignados($idinscripcion, $fotocopia_cedula_madre, $fotocopia_cedula_padre, $fotocopia_cedula_representante, $fotos_representante, $fotocopia_partida_nacimiento, $fotocopia_cedula_estudiante, $fotocopia_constancia_vacunas, $fotos_estudiante, $boleta_promocion, $constancia_buena_conducta, $informe_descriptivo)
  {
    $sql = "INSERT INTO documentos_consignados (id, idinscripcion, fotocopia_cedula_madre, fotocopia_cedula_padre, fotocopia_cedula_representante, fotos_representante, fotocopia_partida_nacimiento, fotocopia_cedula_estudiante, fotocopia_constancia_vacunas, fotos_estudiante, boleta_promocion, constancia_buena_conducta, informe_descriptivo) VALUES (NULL, '$idinscripcion', '$fotocopia_cedula_madre', '$fotocopia_cedula_padre', '$fotocopia_cedula_representante', '$fotos_representante', '$fotocopia_partida_nacimiento', '$fotocopia_cedula_estudiante', '$fotocopia_constancia_vacunas', '$fotos_estudiante', '$boleta_promocion', '$constancia_buena_conducta', '$informe_descriptivo')";

    return ejecutarConsulta($sql);
  }

  #Método para insertar una persona y devolver el id
  function insertar_persona($cedula = NULL, $p_nombre = NULL, $s_nombre = NULL, $p_apellido = NULL, $s_apellido = NULL, $genero = NULL)
  {
    $sql = "INSERT INTO persona (cedula, p_nombre, s_nombre, p_apellido, s_apellido, genero, f_creacion) VALUES('$cedula', '$p_nombre', '$s_nombre', '$p_apellido', '$s_apellido', '$genero', NOW())";

    return ejecutarConsulta_retornarID($sql);
  }

  #Método para editar una persona
  function editar_persona($id, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido)
  {
    $sql = "UPDATE persona SET cedula='$cedula', p_nombre = '$p_nombre', s_nombre = '$s_nombre', p_apellido = '$p_apellido', s_apellido = '$s_apellido' WHERE id = '$id'";

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
    $sql = "INSERT INTO estudiante (id, idpersona, idmadre, idpadre, parto_multiple, orden_nacimiento, estatus) VALUES(NULL, '$idpersona', '$idmadre', '$idpadre', '$parto_multiple', '$orden_nacimiento', '$estatus')";

    return ejecutarConsulta_retornarID($sql);
  }

  #Método para editar registros
  function editar_estudiante($idpersona, $idmadre, $idpadre, $parto_multiple, $orden_nacimiento, $estatus)
  {
    $sql = "UPDATE estudiante SET idmadre = '$idmadre', idpadre = '$idpadre', parto_multiple = '$parto_multiple', orden_nacimiento = '$orden_nacimiento', estatus = '$estatus' WHERE idpersona = '$idpersona'";

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
  function listar()
  {
      $sql = "SELECT p.*, pe.periodo, g.grado, s.seccion, a.ambiente, per.idpersona, persona.p_nombre, persona.p_apellido FROM planificacion p INNER JOIN periodo_escolar pe ON p.idperiodo_escolar = pe.id INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON s.id = p.idseccion INNER JOIN ambiente a ON a.id = p.idambiente INNER JOIN personal per ON per.id = p.iddocente INNER JOIN persona persona ON persona.id = per.idpersona WHERE p.estatus = 1 ORDER BY g.grado, s.seccion";

      return ejecutarConsulta($sql);
  }

  #Método para mostrar los estudiantes inscritos en una planificación
  function mostrar($idplanificacion)
  {
      $sql = "SELECT  est.id, per.cedula, per.p_nombre, per.s_nombre, per.p_apellido, per.s_apellido FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id  INNER JOIN persona per ON est.idpersona = per.id WHERE idplanificacion = '$idplanificacion'";

      return ejecutarConsulta($sql);
  }

  #Método para eliminar planificación
  function eliminar($idplanificacion)
  {
      $sql = "DELETE FROM planificacion WHERE id = $idplanificacion";

      return ejecutarConsulta($sql);
  }

  #Método para traer los estudiantes no inscritos
  function comprobarinscripcion($cedula)
  {
      $sql = "SELECT e.id FROM persona p INNER JOIN estudiante e ON e.idpersona = p.id INNER JOIN inscripcion i ON i.idestudiante = e.id WHERE p.cedula = '$cedula' AND i.estatus = 1;";
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
          $sql = "SELECT p.id, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, d.direccion as direccion_residencia, (SELECT telefono FROM telefono WHERE idpersona = p.id AND tipo = 'M') as celular, (SELECT direccion FROM direccion_trabajo WHERE idpersona = p.id) as direccion_trabajo FROM persona p  LEFT JOIN direccion d ON d.idpersona = p.id WHERE p.cedula = '$cedula'";

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
      $sql = "SELECT id FROM periodo_escolar WHERE estatus = 1";
      return ejecutarConsultaSimpleFila($sql);
  }

  #Método para mostrar las planificaciones con el formato de la vista de inscripción
  public function traerplanificaciones()
  {
      $sql = "SELECT pla.id, gra.grado, sec.seccion, pla.cupo_disponible FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion WHERE pla.estatus = 1 AND pla.cupo_disponible > 0 ORDER BY gra.grado, sec.seccion";
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

}
