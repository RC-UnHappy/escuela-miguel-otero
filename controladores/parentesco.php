<?php

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start();

#Se incluye el modelo de Parentesco
require_once '../modelos/Parentesco.php';

#Se instancia el objeto de Parentesco
$Parentesco = new Parentesco();

$idparentesco = isset($_POST['idparentesco']) ? limpiarCadena($_POST['idparentesco']) : '';
$parentesco = isset($_POST['parentesco']) ? limpiarCadena(mb_strtoupper($_POST['parentesco'])) : '';
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
        if (empty($idparentesco)) {

            #Se registra la parentesco
            $Parentesco->insertar_crud($parentesco, $estatus) or $sw = FALSE;

            #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
            if ($sw) {
                commit();
                echo 'true';
            } else {
                rollback();
                echo 'false';
            }
        } else {

            #Se edita parentesco
            $Parentesco->editar($idparentesco, $parentesco, $estatus) or $sw = FALSE;

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

        $rspta = $Parentesco->listar();

        if ($rspta->num_rows != 0) {

            while ($reg = $rspta->fetch_object()) {

                $data[] = array(
                    '0' => ($reg->estatus) ?

                        // Se verifica que tenga el permiso de editar para mostrar o no el botón
                        ((isset($_SESSION['permisos']['parentesco']) &&
                            in_array('editar', $_SESSION['permisos']['parentesco'])) ?

                            '<button class="btn btn-outline-primary " title="Editar" onclick="mostrar(' . $reg->id . ')" data-toggle="modal" data-target="#parentescoModal"><i class="fas fa-edit"></i></button>' : '') .

                        // Se verifica que tenga el permiso de eliminar para mostrar o no el botón
                        ((isset($_SESSION['permisos']['parentesco']) &&
                            in_array('activar-desactivar', $_SESSION['permisos']['parentesco'])) ?

                            ' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar(' . $reg->id . ')"> <i class="fas fa-times"> </i></button> ' : '')

                        : ((isset($_SESSION['permisos']['parentesco']) &&
                            in_array('editar', $_SESSION['permisos']['parentesco'])) ?

                            '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar(' . $reg->id . ')" data-toggle="modal" data-target="#parentescoModal"><i class="fa fa-edit"></i></button>' : '') .

                        ((isset($_SESSION['permisos']['parentesco']) &&
                            in_array('activar-desactivar', $_SESSION['permisos']['parentesco'])) ?

                            ' <button class="btn btn-outline-success" title="Activar" onclick="activar(' . $reg->id . ')"><i class="fa fa-check"></i></button> ' : ''),

                    '1' => $reg->parentesco
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

        $rspta = $Parentesco->mostrar($idparentesco);

        #Se codifica el resultado utilizando Json
        echo json_encode($rspta);

        break;

    case 'desactivar':

        $rspta = $Parentesco->desactivar($idparentesco);
        echo $rspta ? 'true' : 'false';
        break;

    case 'activar':

        $rspta = $Parentesco->activar($idparentesco);
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
