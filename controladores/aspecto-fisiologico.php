<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de AspectoFisiologico
require_once '../modelos/AspectoFisiologico.php';
#Se instancia el objeto de AspectoFisiologico
$AspectoFisiologico = new AspectoFisiologico();

#Se incluye el modelo de Diversidad Funcional
require_once '../modelos/DiversidadFuncional.php';
$DiversidadFuncional = new DiversidadFuncional();

#Se incluye el modelo de Enfermedad
require_once '../modelos/Enfermedad.php';
$Enfermedad = new Enfermedad();

// Establezco el nombre de las variables de arreglos que vienen por POST, por si vienen vacíos seguir pudiendo usar el nombre de la variable
$diversidad = [];
$enfermedad = [];

// Se establecen todas las variables que vienen por POST por medio de un bucle
foreach ($_POST as $key => $value) {
  $$key = !empty($value) && is_string($value) ? limpiarCadena($value) : !empty($value) && is_array($value) ? $value : '';
}


#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

    // var_dump($_POST);
    // die;
  
		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);
    
		#Variable para comprobar que todo salió bien al final
    $sw = TRUE;
    
    
		#Si la variable idboletinfinal esta vacía quiere decir que es un nuevo registro
		if (empty($idaspectofisiologico)) {
      
      // $idinscripcion = $AspectoFisiologico->traeridinscripcion($idplanificacion, $idestudiante);
      // $idinscripcion = !empty($idinscripcion) ? $idinscripcion['id'] : '';

      #Se registran los aspectos fisiológicos del estudiante
			$id = $AspectoFisiologico->insertar($idplanificacion, $idestudiante, $peso, $talla, $todas_vacunas, $alergia, $c, $alimentos, $utiles, $alergias, $vacunas, $alimentostxt, $utilestxt) or $sw = FALSE;

			#Se registran las diversidades funcionales del estudiante
			$DiversidadFuncional->insertar($id, $diversidad) or $sw = FALSE;

			#Se registran las enfermedades del estudiante
			$Enfermedad->insertar($id, $enfermedad) or $sw = FALSE;

			#Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
			if ($sw) {
				commit();
				echo 'true';
			}
			else {
				rollback();
				echo 'false';
			}

		}
		else{
      
      $sw = TRUE;
      
      #Se editan los aspectos fisiológicos del estudiante
      $AspectoFisiologico->editar($idaspectofisiologico, $peso, $talla, $todas_vacunas, $alergia, $c, $alimentos, $utiles,$alergias, $vacunas, $alimentostxt, $utilestxt) or $sw = FALSE;
      
      #Verifica que la variable de diversidad contenga datos y los guarda
			if (!empty($diversidad)) {
				$DiversidadFuncional->eliminar($idaspectofisiologico) or $sw = FALSE;
				$DiversidadFuncional->insertar($idaspectofisiologico, $diversidad) or $sw = FALSE;
			}
			else {
				$DiversidadFuncional->eliminar($idaspectofisiologico) or $sw = FALSE;
			}

			#Verifica que la variable de enfermedad contenga datos y los guarda
			if (!empty($enfermedad)) {
				$Enfermedad->eliminar($idaspectofisiologico) or $sw = FALSE;
				$Enfermedad->insertar($idaspectofisiologico, $enfermedad) or $sw = FALSE;
			}
			else {
				$Enfermedad->eliminar($idaspectofisiologico) or $sw = FALSE;
			}

			#Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
			if ($sw) {
				commit();
				echo 'update';
			}
			else {
				rollback();
				echo 'false';
			}
		}
    break;

  case 'listar':
    #Establece la zona horaria
    date_default_timezone_set('America/Caracas');
    
    if (!empty($idplanificacion) ){
      $rspta = $AspectoFisiologico->listar($idplanificacion);
      
      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {
          if (!empty($reg->id)) {

            if (!empty($reg->f_nac)) {
              list($anoN, $mesN, $diaN) = explode('-', $reg->f_nac);
              list($anoA, $mesA, $diaA) = explode('-', date('Y-m-d'));
              
              if ($mesN == $mesA) {
                if ($diaN == $diaA) {
                  $edad = $anoA - $anoN;
                  $cumple = ' <span class="pull-right badge badge-light"><i class="fa fa-birthday-cake" style="font-size:18px; color: #F06292;"></i></span><span class="sr-only">Cumpleaños</span>';
                }
                elseif ($diaN < $diaA) {
                  $edad = $anoA - $anoN;
                }
                else {
                  $edad = ($anoA - $anoN) - 1;
                }
              }
              elseif ($mesN > $mesA ) {
                $edad = ($anoA - $anoN) - 1;
                
              }
              else {
                $edad = ($anoA - $anoN);
                
              }  
            }
            else {
              $edad = 'Debe establecer la fecha de nacimiento';
              $cumple = '';
            }
    
            $data[] = array(
            '0' =>  
            ( ( isset($_SESSION['permisos']['aspecto-fisiologico']) && 
                      in_array('editar' , $_SESSION['permisos']['aspecto-fisiologico']) ) ?

            ' <button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#aspectoFisiologicoModal"><i class="fa fa-edit"></i></button>' : ''),

            '1' => ucwords($reg->p_apellido.' '.$reg->s_apellido.' '.$reg->p_nombre.' '.$reg->s_nombre),
            '2' => $edad.$cumple = isset($cumple) ? $cumple : '',
            '3' => $reg->genero,
            '4' => $reg->peso,
            '5' => $reg->talla,
            '6' => ($reg->todas_vacunas) ? 'Si' : 'No',
            '7' => ($reg->alergia) ? 'Si' : 'No',
            '8' => !empty($reg->diversidades_funcionales) ? strtoupper($reg->diversidades_funcionales) : 'No posee',
            '9' => ($reg->c) ? 'Si' : 'No',
            '10' => ($reg->alimentos) ? 'Si' : 'No',
            '11' => ($reg->utiles) ? 'Si' : 'No',
            '12' => !empty($reg->enfermedades) ? strtoupper($reg->enfermedades) : 'No posee'
            );

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
    
        }
      }
      else {
        $results = array(
          "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
          "recordsTotal" => 0, #Se envía el total de registros al datatable
          "recordsFiltered" => 0, #Se envía el total de registros a visualizar
          "data" => '' #datos en un array
  
        );
      }
    }
    else {
			$results = array(
				"draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
				"recordsTotal" => 0, #Se envía el total de registros al datatable
				"recordsFiltered" => 0, #Se envía el total de registros a visualizar
				"data" => '' #datos en un array

			);
		}

		echo json_encode($results);

  break;

  case 'traerplanificaciones': 
    #Traer las planificaciones

    // Se determina el rol que tiene el usuario
    $rol_usuario = isset($_SESSION) ? $_SESSION['rol'] : '';
    $id_usuario = isset($_SESSION) ? $_SESSION['idusuario'] : '';

    $id_docente = $AspectoFisiologico->traerpersonal($id_usuario);
    $id_docente = !empty($id_docente) ? $id_docente['id'] : '';
    
    $periodo_escolar = $AspectoFisiologico->consultarperiodo();
    $idperiodo_escolar = !empty($periodo_escolar) ? $periodo_escolar['id'] : '';

    if ($rol_usuario == 'Docente') {
      $rspta = $AspectoFisiologico->traerplanificaciones($idperiodo_escolar, $id_docente);    
      $data = array();
      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {    
          $data[] = [
            'id' => $reg->id,
            'grado' => $reg->grado,
            'seccion' => $reg->seccion,
            'nombre_docente' => $reg->p_nombre,
            'apellido_docente' => $reg->p_apellido
          ];
        }
      }
    }
    else {
      $rspta = $AspectoFisiologico->traerplanificaciones($idperiodo_escolar);    
      $data = array();
      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {    
          $data[] = [
            'id' => $reg->id,
            'grado' => $reg->grado,
            'seccion' => $reg->seccion,
            'nombre_docente' => $reg->p_nombre,
            'apellido_docente' => $reg->p_apellido
          ];
        }
      }
    }

    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'traerestudiantes': 

    #Traer los estudiantes activos
    $rspta = $AspectoFisiologico->traerestudiantes($idplanificacion);    
    $data = array();
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {    
        $data[] = [
          'id' => $reg->idestudiante,
          'p_nombre' => ucfirst($reg->p_nombre),
          's_nombre' => ucfirst($reg->s_nombre),
          'p_apellido' => ucfirst($reg->p_apellido),
          's_apellido' => ucfirst($reg->s_apellido)
        ];
      }
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'mostrar':

  $rspta = $AspectoFisiologico->mostrar($idaspectofisiologico);

  #Se codifica el resultado utilizando Json
  echo json_encode($rspta);

  break;

}