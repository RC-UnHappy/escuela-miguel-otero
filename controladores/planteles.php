<?php

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start();

#Se incluye el modelo de Planteles
require_once '../modelos/Planteles.php';

#Se instancia el objeto de Planteles
$Planteles = new Planteles();

$idplantel = isset($_POST['idplantel']) ? limpiarCadena($_POST['idplantel']) : '';
$plantel = isset($_POST['plantel']) ? limpiarCadena(mb_strtoupper($_POST['plantel'])) : '';
$estatus = isset($_POST['estatus']) ? limpiarCadena($_POST['estatus']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

    case 'comprobardiversidad':

        $rspta = $Profesion->comprobarprofesion($profesion);
        echo json_encode($rspta->fetch_object());
        break;

    case 'guardaryeditar':

        #Se deshabilita el guardado automático de la base de datos
        autocommit(FALSE);

        #Variable para comprobar que todo salió bien al final
        $sw = TRUE;

        #Si la variable esta vacía quiere decir que es un nuevo registro
        if (empty($idplantel)) {

            #Se registra la parentesco
            $Planteles->insertar_crud($plantel, $estatus) or $sw = FALSE;

            #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
            if ($sw) {
                commit();
                echo 'true';
            } else {
                rollback();
                echo 'false';
            }
        } else {

            #Se edita plantel
            $Planteles->editar($idplantel, $plantel, $estatus) or $sw = FALSE;

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

        $rspta = $Planteles->listar();

        if ($rspta->num_rows != 0) {

            while ($reg = $rspta->fetch_object()) {

                $data[] = array(
                    '0' => ($reg->estatus) ?

                        // Se verifica que tenga el permiso de editar para mostrar o no el botón
                        ((isset($_SESSION['permisos']['planteles']) &&
                            in_array('editar', $_SESSION['permisos']['planteles'])) ?

                            '<button class="btn btn-outline-primary " title="Editar" onclick="mostrar(' . $reg->id . ')" data-toggle="modal" data-target="#plantelesModal"><i class="fas fa-edit"></i></button>' : '') .

                        // Se verifica que tenga el permiso de eliminar para mostrar o no el botón
                        ((isset($_SESSION['permisos']['planteles']) &&
                            in_array('activar-desactivar', $_SESSION['permisos']['planteles'])) ?

                            ' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar(' . $reg->id . ')"> <i class="fas fa-times"> </i></button> ' : '')

                        : ((isset($_SESSION['permisos']['planteles']) &&
                            in_array('editar', $_SESSION['permisos']['planteles'])) ?

                            '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar(' . $reg->id . ')" data-toggle="modal" data-target="#plantelesModal"><i class="fa fa-edit"></i></button>' : '') .

                        ((isset($_SESSION['permisos']['planteles']) &&
                            in_array('activar-desactivar', $_SESSION['permisos']['planteles'])) ?

                            ' <button class="btn btn-outline-success" title="Activar" onclick="activar(' . $reg->id . ')"><i class="fa fa-check"></i></button> ' : ''),

                    '1' => $reg->plantel
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

        $rspta = $Planteles->mostrar($idplantel);

        #Se codifica el resultado utilizando Json
        echo json_encode($rspta);

        break;

    case 'desactivar':

        $rspta = $Planteles->desactivar($idplantel);
        echo $rspta ? 'true' : 'false';
        break;

    case 'activar':

        $rspta = $Planteles->activar($idplantel);
        echo $rspta ? 'true' : 'false';
        break;

    case 'traer-diversidades':

        $diversidades_objeto = $DiversidadFuncional->listar();
        $diversidades = "";
        if ($diversidades_objeto->num_rows != 0) {
            while ($fila = $diversidades_objeto->fetch_object()) {
                $diversidades .= '
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input diversidad" id="' . $fila->diversidad . '" value="' . $fila->diversidad . '" name="diversidad[]">
                    <label class="custom-control-label" for="' . $fila->diversidad . '">' . $fila->diversidad . '</label>
                </div>';
            }
        }

        echo $diversidades;
        return;
        break;
}
