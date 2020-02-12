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

    #Método para insertar la inscripción
    function insertar($idperiodo_escolar, $idplanificacion, $idestudiante, $idrepresentante, $estatus)
    {
        $sql = "INSERT INTO inscripcion (id, idperiodo_escolar, idplanificacion, idestudiante, idrepresentante, fecha_inscripcion, estatus) VALUES(NULL, '$idperiodo_escolar', '$idplanificacion', '$idestudiante', '$idrepresentante', CURDATE(), $estatus)";
    
        return ejecutarConsulta($sql);
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

    #Método para mostrar una planificación
    function mostrar($idplanificacion)
    {
        $sql = "SELECT p.*, g.grado, s.seccion, a.ambiente, pe.p_nombre, pe.p_apellido FROM planificacion p  INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON p.idseccion = s.id INNER JOIN ambiente a ON p.idambiente = a.id INNER JOIN personal per ON p.iddocente = per.id INNER JOIN persona pe ON per.idpersona = pe.id WHERE p.id = '$idplanificacion'";

        return ejecutarConsultaSimpleFila($sql);
    }



    #Método para eliminar planificación
    function eliminar($idplanificacion)
    {
        $sql = "DELETE FROM planificacion WHERE id = $idplanificacion";

        return ejecutarConsulta($sql);
    }

    #Método para traer los estudiantes no inscritos
    function traerestudiantes()
    {
        $sql = "SELECT est.id as idE, per.cedula as cedulaE, per.p_nombre as nombreE, per.p_apellido as apellidoE FROM estudiante as est INNER JOIN persona as per ON per.id = est.idpersona WHERE est.id NOT IN(SELECT idestudiante FROM inscripcion WHERE idperiodo_escolar = (SELECT id FROM periodo_escolar WHERE estatus = 1))";
        
        return ejecutarConsulta($sql);
    }

    #Método para traer los representantes activos
    function traerrepresentantes()
    {
        $sql = "SELECT r.id as id, p.cedula as cedula, p.p_nombre as nombre, p.p_apellido as apellido FROM representante as r INNER JOIN persona as p ON p.id = r.idpersona WHERE r.estatus = 1";
        return ejecutarConsulta($sql);
    }

    #Método para traer los ambientes que estén disponibles
    function traerambientes($idambiente)
    {
        if ($idambiente != NULL) {
            $sql = "SELECT a.* FROM ambiente a WHERE a.estatus = 1 AND a.id NOT IN(SELECT idambiente FROM planificacion WHERE idambiente != $idambiente) ORDER BY a.ambiente";
        } else {
            $sql = "SELECT a.* FROM ambiente a WHERE a.estatus = 1 AND a.id NOT IN(SELECT idambiente FROM planificacion) ORDER BY a.ambiente";
        }

        return ejecutarConsulta($sql);
    }

    #Método para traer las secciones que estén disponibles
    function traerdocentes($iddocente)
    {
        if ($iddocente != NULL) {
            $sql = "SELECT DISTINCT per.id, p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal per ON p.id = per.idpersona WHERE per.cargo LIKE '%Docente%' AND per.estatus = 1 AND per.id NOT IN (SELECT iddocente FROM planificacion WHERE iddocente != $iddocente)";
        } else {
            $sql = "SELECT DISTINCT per.id, p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal per ON p.id = per.idpersona WHERE per.cargo LIKE '%Docente%' AND per.estatus = 1 AND per.id NOT IN (SELECT iddocente FROM planificacion)";
        }

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
        $sql = "SELECT pla.id, gra.grado, sec.seccion, persona.p_nombre, persona.p_apellido FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion INNER JOIN personal per ON per.id = pla.iddocente INNER JOIN persona persona ON persona.id = per.idpersona WHERE pla.estatus = 1 ORDER BY gra.grado, sec.seccion";
        return ejecutarConsulta($sql);
    }

}
