<?php

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Lapso
 */
class Lapso
{

    #Constructor de la clase
    public function __construct()
    { }

    #Método para insertar registros
    function insertar($seccion, $estatus)
    {
        $sql = "INSERT INTO seccion (seccion, estatus) VALUES('$seccion', '$estatus')";

        return ejecutarConsulta($sql);
    }

    #Método para editar registros
    function editar($idseccion, $seccion, $estatus)
    {
        $sql = "UPDATE seccion SET seccion='$seccion', estatus = '$estatus' WHERE id = '$idseccion'";

        return ejecutarConsulta($sql);
    }

    #Método para listar todos las secciones
    function listar()
    {
        $sql = "SELECT * FROM seccion";

        return ejecutarConsulta($sql);
    }

    #Método para mostrar un ambiente
    function mostrar($idseccion)
    {
        $sql = "SELECT * FROM seccion WHERE id = '$idseccion'";

        return ejecutarConsultaSimpleFila($sql);
    }



    #Método para desactivar ambiente
    function desactivar($idseccion)
    {
        $sql = "UPDATE seccion SET estatus = '0' WHERE id = '$idseccion'";

        return ejecutarConsulta($sql);
    }

    #Método para activar ambiente
    function activar($idseccion)
    {
        $sql = "UPDATE seccion SET estatus = '1' WHERE id = '$idseccion'";

        return ejecutarConsulta($sql);
    }

    #Método para comprobar si existe el Lapso
    function comprobarlapso($lapso)
    {
        $sql = "SELECT lapso FROM lapso WHERE lapso = '$lapso'";
        return ejecutarConsulta($sql);
    }
}
