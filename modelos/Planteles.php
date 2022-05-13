<?php

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Planteles
 */
class Planteles
{

    #Constructor de la clase
    public function __construct()
    {
    }

    #Método para insertar registros
    function insertar($idaspecto_fisiologico, $diversidad)
    {
        $sw = TRUE;

        if ($diversidad != '') {
            for ($i = 0; $i < count($diversidad); $i++) {
                $sql = "INSERT INTO diversidad_funcionals (id, idaspecto_fisiologico, diversidad) VALUES(NULL, '$idaspecto_fisiologico' ,'$diversidad[$i]')";

                ejecutarConsulta($sql) or $sw = FALSE;
            }
        }

        return $sw;
    }

    #Método para eliminar registros
    function eliminar($idaspecto_fisiologico)
    {
        $sql = "DELETE FROM diversidad_funcionals WHERE idaspecto_fisiologico = '$idaspecto_fisiologico'";

        return ejecutarConsulta($sql);
    }

    #Método para insertar registros
    function insertar_crud($plantel, $estatus)
    {
        $sql = "INSERT INTO planteles (plantel, estatus) VALUES('$plantel', '$estatus')";

        return ejecutarConsulta($sql);
    }

    function editar($idplantel, $plantel, $estatus)
    {
        $sql = "UPDATE planteles SET plantel='$plantel', estatus = '$estatus' WHERE id = '$idplantel'";

        return ejecutarConsulta($sql);
    }

    function listar()
    {
        $sql = "SELECT * FROM planteles";

        return ejecutarConsulta($sql);
    }

    function mostrar($idplantel)
    {
        $sql = "SELECT * FROM planteles WHERE id = '$idplantel'";

        return ejecutarConsultaSimpleFila($sql);
    }

    function desactivar($idplantel)
    {
        $sql = "UPDATE planteles SET estatus = '0' WHERE id = '$idplantel'";

        return ejecutarConsulta($sql);
    }

    function activar($idplantel)
    {
        $sql = "UPDATE planteles SET estatus = '1' WHERE id = '$idplantel'";

        return ejecutarConsulta($sql);
    }

    function buscar($plantel)
    {
        $sql = "SELECT * FROM planteles WHERE plantel = '$plantel'";
        return ejecutarConsulta($sql);
    }
}
