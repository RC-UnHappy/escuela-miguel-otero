<?php

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start();

#Se incluye el modelo de inscripción Inicial
require_once '../../modelos/inscripcion/Inicial.php';

#Se instancia el objeto de inscripción Incial
$Inicial = new Inicial();

$idinscripcion = isset($_POST['idinscripcion']) ? limpiarCadena($_POST['idinscripcion']) : '';
$idplanificacion = isset($_POST['idplanificacion']) ? limpiarCadena($_POST['idplanificacion']) : '';
$idestudiante = isset($_POST['idestudiante']) ? limpiarCadena($_POST['idestudiante']) : '';
$idrepresentante = isset($_POST['idrepresentante']) ? limpiarCadena($_POST['idrepresentante']) : '';
$estatus = isset($_POST['estatus']) ? limpiarCadena($_POST['estatus']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

    case 'guardaryeditar':

        #Se deshabilita el guardado automático de la base de datos
        autocommit(FALSE);

        #Variable para comprobar que todo salió bien al final
        $sw = TRUE;

        #Si la variable esta vacía quiere decir que es un nuevo registro
        if (empty($idinscripcion)) {

            #Se trae el id del período escolar en curso
            $idperiodo_escolar = $Inicial->consultarperiodo() or $sw = FALSE;

            #Se comprueba que haya cupo disponible en la planificación
            $cupo_disponible = $Inicial->verificarcupodisponible($idplanificacion) or $sw = FALSE;

            if($cupo_disponible = 0)
                $sw = FALSE;
            
            #Método para restar un cupo a la planificación
            $Inicial->restarcupo($idplanificacion) or $sw = FALSE;
            
            #Se registra la inscripción
            $Inicial->insertar($idperiodo_escolar['id'], $idplanificacion, $idestudiante, $idrepresentante, $estatus) or $sw = FALSE;

            #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
            if ($sw) {
                commit();
                echo 'true';
            } else {
                rollback();
                echo 'false';
            }
        } else {

            #Se edita la planificación
            $Inicial->editar($idplanificacion, $idgrado, $idseccion, $idambiente, $iddocente, $cupo) or $sw = FALSE;

            #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
            if ($sw) {
                commit();
                echo 'update';
            } else {
                rollback();
                echo 'false';
            }
        }
        break;

    case 'listar':

        $rspta = $Inicial->listar();

        if ($rspta->num_rows != 0) {
            while ($reg = $rspta->fetch_object()) {

                $percentage = ($reg->cupo_disponible * 100) / $reg->cupo;
                $percentage = 100 - $percentage;
                $percentage_color = ($percentage >= 50 && $percentage < 75) ? 'bg-warning' 
                : ($percentage >= 75) ? 'bg-danger' 
                : 'bg-success';

                $data[] = array(
                    '0' => ($reg->estatus) ?

                        '<button class="btn btn-outline-primary " title="Ver sección" onclick="mostrar(' . $reg->id . ')" data-toggle="modal" data-target="#estudiantesSeccionModal"><i class="fas fa-eye"></i></button>' 

                        : 
                        
                        '<button class="btn btn-outline-primary" title="Ver sección" onclick="mostrar(' . $reg->id . ')" data-toggle="modal" data-target="#estudiantesSeccionModal"><i class="fas fa-eye"></i></button>',

                    '1' => $reg->grado . ' º',
                    '2' => '"' . $reg->seccion . '"',
                    '3' => $reg->p_nombre . ' ' . $reg->p_apellido,
                    '4' => '<div class="text-uppercase">
                                <small>
                                    <b>Porcentaje de Ocupación</b>
                                </small>
                            </div>
                            <div class="progress bg-secondary" style="height: 30px;" bg-success>
                                <div class="progress-bar '.$percentage_color.'"                  role="progressbar" style="width: '.$percentage.'%; color:white;"           aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100">'.number_format($percentage, 1).' %
                                </div>
                            </div>
                            <small >'.($reg->cupo - $reg->cupo_disponible).' / '.$reg->cupo. ' cupos</small>',
                    '5' => $reg->periodo
                );
            }

            $results = array(
                "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
                "recordsTotal" => count($data), #Se envía el total de registros al datatable
                "recordsFiltered" => count($data), #Se envía el total de registros a visualizar
                "data" => $data #datos en un array

            );
        } else {
            $results = array(
                "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
                "recordsTotal" => 0, #Se envía el total de registros al datatable
                "recordsFiltered" => 0, #Se envía el total de registros a visualizar
                "data" => '' #datos en un array

            );
        }

        echo json_encode($results);

        break;

    case 'mostrar':

        $idplanificacion = isset($_GET['idplanificacion']) ? limpiarCadena($_GET['idplanificacion']) : '';
        $rspta = $Inicial->mostrar($idplanificacion);

        $data = array();
        if ($rspta->num_rows != 0) {
            while ($reg = $rspta->fetch_object()) {

                $data[] = [
                    '0' => '
                    <button class="btn btn-outline-danger" title="Retirar estudiante" onclick="desactivar('.$reg->id.')"> <i class="fas fa-times"> </i></button>',
                    '1' => $reg->cedula,
                    '2' => $reg->p_nombre,
                    '3' => $reg->s_nombre,
                    '4' => $reg->p_apellido,
                    '5' => $reg->s_apellido
                ];
            }

            $results = array(
                "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
                "recordsTotal" => count($data), #Se envía el total de registros al datatable
                "recordsFiltered" => count($data), #Se envía el total de registros a visualizar
                "data" => $data #datos en un array

            );
        }
        else {
            $results = array(
                "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
                "recordsTotal" => 0, #Se envía el total de registros al datatable
                "recordsFiltered" => 0, #Se envía el total de registros a visualizar
                "data" => '' #datos en un array

            );
        }

        #Se codifica el resultado utilizando Json
        echo json_encode($results);

        break;

    case 'eliminar':

        $rspta = $Planificacion->eliminar($idplanificacion);
        echo $rspta ? 'true' : 'false';
        break;

    case 'traerestudiantes':

        $rspta = $Inicial->traerestudiantes();

        $data = array();
        if ($rspta->num_rows != 0) {
            while ($reg = $rspta->fetch_object()) {

                $data[] = [
                    'id' => $reg->idE,
                    'cedula' => $reg->cedulaE,
                    'nombre' => $reg->nombreE,
                    'apellido' => $reg->apellidoE
                ];
            }
        }

        #Se codifica el resultado utilizando Json
        echo json_encode($data);
        break;

    case 'traerplanificaciones':

        #Traer la planificaciones disponibles
        $rspta = $Inicial->traerplanificaciones();

        $data = array();
        if ($rspta->num_rows != 0) {
            while ($reg = $rspta->fetch_object()) {

                $data[] = [
                    'id' => $reg->id,
                    'grado' => $reg->grado,
                    'seccion' => $reg->seccion,
                    'docente' => $reg->p_nombre .' '.$reg->p_apellido
                ];
            }
        }

        #Se codifica el resultado utilizando Json
        echo json_encode($data);
        break;

    case 'traerrepresentantes':

        $rspta = $Inicial->traerrepresentantes();

        $data = array();
        if ($rspta->num_rows != 0) {
            while ($reg = $rspta->fetch_object()) {

                $data[] = [
                    'id' => $reg->id,
                    'cedula' => $reg->cedula,
                    'nombre' => $reg->nombre,
                    'apellido' => $reg->apellido
                ];
            }
        }

        #Se codifica el resultado utilizando Json
        echo json_encode($data);
        break;

    case 'traerdocentes':

        #iddocente es un parámetro que puede o no estar vacío
        $rspta = $Planificacion->traerdocentes($iddocente);

        $data = array();
        if ($rspta->num_rows != 0) {
            while ($reg = $rspta->fetch_object()) {

                $data[] = [
                    'id' => $reg->id,
                    'p_nombre' => $reg->p_nombre,
                    'p_apellido' => $reg->p_apellido
                ];
            }
        }

        #Se codifica el resultado utilizando Json
        echo json_encode($data);
        break;
}
