<?php

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start();

#Se incluye el modelo de inscripción 
require_once '../../modelos/inscripcion/Inscripcion.php';
#Se instancia el objeto de inscripción Incial
$Inscripcion = new Inscripcion;

/**
 * Variables de estudiante
 */
$cedula_estudiante = isset($_POST['cedula_estudiante']) ? limpiarCadena($_POST['cedula_estudiante']) : '';
$p_nombre_estudiante = isset($_POST['p_nombre_estudiante']) ? limpiarCadena($_POST['p_nombre_estudiante']) : '';
$s_nombre_estudiante = isset($_POST['s_nombre_estudiante']) ? limpiarCadena($_POST['s_nombre_estudiante']) : '';
$p_apellido_estudiante = isset($_POST['p_apellido_estudiante']) ? limpiarCadena($_POST['p_apellido_estudiante']) : '';
$s_apellido_estudiante = isset($_POST['s_apellido_estudiante']) ? limpiarCadena($_POST['s_apellido_estudiante']) : '';
$genero_estudiante = isset($_POST['genero_estudiante']) ? limpiarCadena($_POST['genero_estudiante']) : '';
$f_nac_estudiante = isset($_POST['f_nac_estudiante']) ? limpiarCadena($_POST['f_nac_estudiante']) : '';
$parto = isset($_POST['parto']) ? limpiarCadena($_POST['parto']) : '';
$orden = isset($_POST['orden']) ? limpiarCadena($_POST['orden']) : '';
$pais_nacimiento_estudiante = isset($_POST['pais_nacimiento_estudiante']) ? limpiarCadena($_POST['pais_nacimiento_estudiante']) : '';
$estado_nacimiento_estudiante = isset($_POST['estado_nacimiento_estudiante']) ? limpiarCadena($_POST['estado_nacimiento_estudiante']) : '';
$municipio_nacimiento_estudiante = isset($_POST['municipio_nacimiento_estudiante']) ? limpiarCadena($_POST['municipio_nacimiento_estudiante']) : '';
$parroquia_nacimiento_estudiante = isset($_POST['parroquia_nacimiento_estudiante']) ? limpiarCadena($_POST['parroquia_nacimiento_estudiante']) : '';
$plantel_procedencia_estudiante = isset($_POST['plantel_procedencia_estudiante']) ? limpiarCadena($_POST['plantel_procedencia_estudiante']) : '';
$plantel_procedencia_estudiante = isset($_POST['plantel_procedencia_estudiante']) ? limpiarCadena($_POST['plantel_procedencia_estudiante']) : '';

/**
 * Variables de madre
 */
$idmadre = isset($_POST['idmadre']) ? limpiarCadena($_POST['idmadre']) : '';
$idpersonamadre = isset($_POST['idpersonamadre']) ? limpiarCadena($_POST['idpersonamadre']) : '';
$cedula_madre = isset($_POST['cedula_madre']) ? limpiarCadena($_POST['cedula_madre']) : '';
$p_nombre_madre = isset($_POST['p_nombre_madre']) ? limpiarCadena($_POST['p_nombre_madre']) : '';
$s_nombre_madre = isset($_POST['s_nombre_madre']) ? limpiarCadena($_POST['s_nombre_madre']) : '';
$p_apellido_madre = isset($_POST['p_apellido_madre']) ? limpiarCadena($_POST['p_apellido_madre']) : '';
$s_apellido_madre = isset($_POST['s_apellido_madre']) ? limpiarCadena($_POST['s_apellido_madre']) : '';
$oficio_madre = isset($_POST['oficio_madre']) ? limpiarCadena($_POST['oficio_madre']) : '';
$celular_madre = isset($_POST['celular_madre']) ? limpiarCadena($_POST['celular_madre']) : '';
$direccion_residencia_madre = isset($_POST['direccion_residencia_madre']) ? limpiarCadena($_POST['direccion_residencia_madre']) : '';
$direccion_trabajo_madre = isset($_POST['direccion_trabajo_madre']) ? limpiarCadena($_POST['direccion_trabajo_madre']) : '';

/**
 * Variable de padre
 */
$idpadre = isset($_POST['idpadre']) ? limpiarCadena($_POST['idpadre']) : '';
$idpersonapadre = isset($_POST['idpersonapadre']) ? limpiarCadena($_POST['idpersonapadre']) : '';
$cedula_padre = isset($_POST['cedula_padre']) ? limpiarCadena($_POST['cedula_padre']) : '';
$p_nombre_padre = isset($_POST['p_nombre_padre']) ? limpiarCadena($_POST['p_nombre_padre']) : '';
$s_nombre_padre = isset($_POST['s_nombre_padre']) ? limpiarCadena($_POST['s_nombre_padre']) : '';
$p_apellido_padre = isset($_POST['p_apellido_padre']) ? limpiarCadena($_POST['p_apellido_padre']) : '';
$s_apellido_padre = isset($_POST['s_apellido_padre']) ? limpiarCadena($_POST['s_apellido_padre']) : '';
$oficio_padre = isset($_POST['oficio_padre']) ? limpiarCadena($_POST['oficio_padre']) : '';
$celular_padre = isset($_POST['celular_padre']) ? limpiarCadena($_POST['celular_padre']) : '';
$direccion_residencia_padre = isset($_POST['direccion_residencia_padre']) ? limpiarCadena($_POST['direccion_residencia_padre']) : '';
$direccion_trabajo_padre = isset($_POST['direccion_trabajo_padre']) ? limpiarCadena($_POST['direccion_trabajo_padre']) : '';

/**
 * Variable de representante
 */
$idrepresentante = isset($_POST['idrepresentante']) ? limpiarCadena($_POST['idrepresentante']) : '';
$idpersonarepresentante = isset($_POST['idpersonarepresentante']) ? limpiarCadena($_POST['idpersonarepresentante']) : '';
$tiporepresentante = isset($_POST['tiporepresentante']) ? limpiarCadena($_POST['tiporepresentante']) : '';
$cedula_representante = isset($_POST['cedula_representante']) ? limpiarCadena($_POST['cedula_representante']) : '';
$p_nombre_representante = isset($_POST['p_nombre_representante']) ? limpiarCadena($_POST['p_nombre_representante']) : '';
$s_nombre_representante = isset($_POST['s_nombre_representante']) ? limpiarCadena($_POST['s_nombre_representante']) : '';
$p_apellido_representante = isset($_POST['p_apellido_representante']) ? limpiarCadena($_POST['p_apellido_representante']) : '';
$s_apellido_representante = isset($_POST['s_apellido_representante']) ? limpiarCadena($_POST['s_apellido_representante']) : '';
$oficio_representante = isset($_POST['oficio_representante']) ? limpiarCadena($_POST['oficio_representante']) : '';
$celular_representante = isset($_POST['celular_representante']) ? limpiarCadena($_POST['celular_representante']) : '';
$genero_representante = isset($_POST['genero_representante']) ? limpiarCadena($_POST['genero_representante']) : '';
$parentesco_representante = isset($_POST['parentesco_representante']) ? limpiarCadena($_POST['parentesco_representante']) : '';
$direccion_residencia_representante = isset($_POST['direccion_residencia_representante']) ? limpiarCadena($_POST['direccion_residencia_representante']) : '';
$direccion_trabajo_representante = isset($_POST['direccion_trabajo_representante']) ? limpiarCadena($_POST['direccion_trabajo_representante']) : '';

/**
 * Variables de documentos consignados
 */
$documentos_consignados = isset($_POST['documentos_consignados']) ? $_POST['documentos_consignados'] : [];

$fotocopia_cedula_madre = in_array('fotocopia_cedula_madre', $documentos_consignados) ? 1 : 0;
$fotocopia_cedula_padre = in_array('fotocopia_cedula_padre', $documentos_consignados) ? 1 : 0;
$fotocopia_cedula_representante = in_array('fotocopia_cedula_representante', $documentos_consignados) ? 1 : 0;
$fotos_representante = in_array('fotos_representante', $documentos_consignados) ? 1 : 0;
$fotocopia_partida_nacimiento = in_array('fotocopia_partida_nacimiento', $documentos_consignados) ? 1 : 0;
$fotocopia_cedula_estudiante = in_array('fotocopia_cedula_estudiante', $documentos_consignados) ? 1 : 0;
$fotocopia_constancia_vacunas = in_array('fotocopia_constancia_vacunas', $documentos_consignados) ? 1 : 0;
$fotos_estudiante = in_array('fotos_estudiante', $documentos_consignados) ? 1 : 0;
$boleta_promocion = in_array('boleta_promocion', $documentos_consignados) ? 1 : 0;
$constancia_buena_conducta = in_array('constancia_buena_conducta', $documentos_consignados) ? 1 : 0;
$informe_descriptivo = in_array('informe_descriptivo', $documentos_consignados) ? 1 : 0;

/**
 * Variables de inscripción
 */
$idplanificacion = isset($_POST['idplanificacion']) ? limpiarCadena($_POST['idplanificacion']) : '';
// $repite = isset($_POST['repite']) ? limpiarCadena($_POST['repite']) : '';
$observaciones = isset($_POST['observaciones']) ? limpiarCadena($_POST['observaciones']) : '';

/**
 * Variables de inscripción regular
 */
$idinscripcionregular = isset($_POST['idinscripcionregular']) ? limpiarCadena($_POST['idinscripcionregular']) : '';
$idestudiante_regular = isset($_POST['idestudiante_regular']) ? limpiarCadena($_POST['idestudiante_regular']) : '';
$idsiguienteperiodo = isset($_POST['idsiguienteperiodo']) ? limpiarCadena($_POST['idsiguienteperiodo']) : '';
$idperiodo_escolar_regular = isset($_POST['idperiodo_escolar_regular']) ? limpiarCadena($_POST['idperiodo_escolar_regular']) : '';
$idplanificacion_regular = isset($_POST['idplanificacion_regular']) ? limpiarCadena($_POST['idplanificacion_regular']) : '';
$grado_regular = isset($_POST['grado_regular']) ? limpiarCadena($_POST['grado_regular']) : '';
$seccion_regular = isset($_POST['seccion_regular']) ? limpiarCadena($_POST['seccion_regular']) : '';
$observaciones_regular = isset($_POST['observaciones_regular']) ? limpiarCadena($_POST['observaciones_regular']) : '';
$estatus_regular = isset($_POST['estatus_regular']) ? limpiarCadena($_POST['estatus_regular']) : '';

/**
 * Variable de representante regular
 */
$idrepresentante_regular = isset($_POST['idrepresentante_regular']) ? limpiarCadena($_POST['idrepresentante_regular']) : '';
$idpersonarepresentante_regular = isset($_POST['idpersonarepresentante_regular']) ? limpiarCadena($_POST['idpersonarepresentante_regular']) : '';
$cedula_representante_regular = isset($_POST['cedula_representante_regular']) ? limpiarCadena($_POST['cedula_representante_regular']) : '';
$p_nombre_representante_regular = isset($_POST['p_nombre_representante_regular']) ? limpiarCadena($_POST['p_nombre_representante_regular']) : '';
$s_nombre_representante_regular = isset($_POST['s_nombre_representante_regular']) ? limpiarCadena($_POST['s_nombre_representante_regular']) : '';
$p_apellido_representante_regular = isset($_POST['p_apellido_representante_regular']) ? limpiarCadena($_POST['p_apellido_representante_regular']) : '';
$s_apellido_representante_regular = isset($_POST['s_apellido_representante_regular']) ? limpiarCadena($_POST['s_apellido_representante_regular']) : '';
$oficio_representante_regular = isset($_POST['oficio_representante_regular']) ? limpiarCadena($_POST['oficio_representante_regular']) : '';
$celular_representante_regular = isset($_POST['celular_representante_regular']) ? limpiarCadena($_POST['celular_representante_regular']) : '';
$genero_representante_regular = isset($_POST['genero_representante_regular']) ? limpiarCadena($_POST['genero_representante_regular']) : '';
$parentesco_representante_regular = isset($_POST['parentesco_representante_regular']) ? limpiarCadena($_POST['parentesco_representante_regular']) : '';
$direccion_residencia_representante_regular = isset($_POST['direccion_residencia_representante_regular']) ? limpiarCadena($_POST['direccion_residencia_representante_regular']) : '';
$direccion_trabajo_representante_regular = isset($_POST['direccion_trabajo_representante_regular']) ? limpiarCadena($_POST['direccion_trabajo_representante_regular']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
  
  case 'inscribir':
    #Se deshabilita el guardado automático de la base de datos
    autocommit(FALSE);
    #Variable para comprobar que todo salió bien al final
    $sw = TRUE;
    
    

    /**
     * Operaciones relacionadas con el registro, actualización de la madre
     */
    if (empty($idmadre) && empty($idpersonamadre)) {
      $idpersonamadre = $Inscripcion->insertar_persona($cedula_madre, $p_nombre_madre, $s_nombre_madre, $p_apellido_madre, $s_apellido_madre, 'F') or $sw = FALSE;
      
      $Inscripcion->insertar_direccion_residencial($idpersonamadre, 'NULL', $direccion_residencia_madre) or $sw = FALSE;
      
      
      $Inscripcion->insertar_direccion_trabajo($idpersonamadre, 'NUll', $direccion_trabajo_madre) or $sw = FALSE;
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_madre))
      $Inscripcion->insertar_telefono($idpersonamadre, $celular_madre, 'M') or $sw = FALSE;
      
      #Se registra el representante
      $idmadre = $Inscripcion->insertar_representante($idpersonamadre, NULL, $oficio_madre) or $sw = FALSE;
    }
    // Cuando la persona ya estaba registrada pero no como representante
    else if(!empty($idpersonamadre) && empty($idmadre)) {
      #Se editan los datos de la persona
      $Inscripcion->editar_persona($idpersonamadre, $cedula_madre, $p_nombre_madre, $s_nombre_madre, $p_apellido_madre, $s_apellido_madre, 'F') or $sw = FALSE;
      
      if ($Inscripcion->verificar_direccion_residencial($idpersonamadre)) {
        $Inscripcion->editar_direccion_residencial($idpersonamadre,  $direccion_residencia_madre) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_residencial($idpersonamadre, 'NULL', $direccion_residencia_madre) or $sw = FALSE;
      }
      
      if ($Inscripcion->verificar_direccion_trabajo($idpersonamadre)) {
        $Inscripcion->editar_direccion_trabajo($idpersonamadre, $direccion_trabajo_madre) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_trabajo($idpersonamadre, 'NULL', $direccion_trabajo_madre) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_madre)) {
        $Inscripcion->eliminar_telefono($idpersonamadre, 'M') or $sw = FALSE;
        $Inscripcion->insertar_telefono($idpersonamadre, $celular_madre, 'M') or $sw = FALSE;
      } else {
        $Inscripcion->eliminar_telefono($idpersonamadre, 'M') or $sw = FALSE;
      }
      
      #Se registra el representante
      $idmadre = $Inscripcion->insertar_representante($idpersonamadre, NULL, $oficio_madre) or $sw = FALSE;
    }
    else {
      #Se obtiene el id de la persona 
      $idpersonamadre = $Inscripcion->idpersona($idmadre);
      $idpersonamadre = $idpersonamadre['idpersona'];
      
      #Se editan los datos de la persona
      $Inscripcion->editar_persona($idpersonamadre, $cedula_madre, $p_nombre_madre, $s_nombre_madre, $p_apellido_madre, $s_apellido_madre, 'F') or $sw = FALSE;
      
      if ($Inscripcion->verificar_direccion_residencial($idpersonamadre)) {
        $Inscripcion->editar_direccion_residencial($idpersonamadre,  $direccion_residencia_madre) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_residencial($idpersonamadre, 'NULL', $direccion_residencia_madre) or $sw = FALSE;
      }
      
      if ($Inscripcion->verificar_direccion_trabajo($idpersonamadre)) {
        $Inscripcion->editar_direccion_trabajo($idpersonamadre, $direccion_trabajo_madre) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_trabajo($idpersonamadre, 'NULL', $direccion_trabajo_madre) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_madre)) {
        $Inscripcion->eliminar_telefono($idpersonamadre, 'M') or $sw = FALSE;
        $Inscripcion->insertar_telefono($idpersonamadre, $celular_madre, 'M') or $sw = FALSE;
      } else {
        $Inscripcion->eliminar_telefono($idpersonamadre, 'M') or $sw = FALSE;
      }
      
      #Se edita el representante
      $rspta = $Inscripcion->editar_representante($idpersonamadre, $oficio_madre) or $sw = FALSE;
      
    }
    
    /**
     * Operaciones relacionadas con el registro, actualización del padre
     */
    if (empty($idpadre) && empty($idpersonapadre)) {
      if (!empty($cedula_padre)) {
        $idpersonapadre = $Inscripcion->insertar_persona($cedula_padre, $p_nombre_padre, $s_nombre_padre, $p_apellido_padre, $s_apellido_padre, 'M') or $sw = FALSE;
        
        $Inscripcion->insertar_direccion_residencial($idpersonapadre, 'NULL', $direccion_residencia_padre) or $sw = FALSE;
        
        $Inscripcion->insertar_direccion_trabajo($idpersonapadre, 'NUll', $direccion_trabajo_padre) or $sw = FALSE;
        
        #Verifica que las variables de los teléfonos contengan datos y los guarda
        if (!empty($celular_padre))
        $Inscripcion->insertar_telefono($idpersonapadre, $celular_padre, 'M') or $sw = FALSE;
        
        #Se registra el representante
        $idpadre = $Inscripcion->insertar_representante($idpersonapadre, NULL, $oficio_padre) or $sw = FALSE;
      }
    }
    // Cuando la persona ya estaba registrada pero no como representante
    else if (!empty($idpersonapadre) && empty($idpadre)) {
      #Se editan los datos de la persona
      $Inscripcion->editar_persona($idpersonapadre, $cedula_padre, $p_nombre_padre, $s_nombre_padre, $p_apellido_padre, $s_apellido_padre, 'M') or $sw = FALSE;
      
      if ($Inscripcion->verificar_direccion_residencial($idpersonapadre)) {
        $Inscripcion->editar_direccion_residencial($idpersonapadre,  $direccion_residencia_padre) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_residencial($idpersonapadre, 'NULL', $direccion_residencia_padre) or $sw = FALSE;
      }
      
      if ($Inscripcion->verificar_direccion_trabajo($idpersonapadre)) {
        $Inscripcion->editar_direccion_trabajo($idpersonapadre, $direccion_trabajo_padre) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_trabajo($idpersonapadre, 'NULL', $direccion_trabajo_padre) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_padre)) {
        $Inscripcion->eliminar_telefono($idpersonapadre, 'M') or $sw = FALSE;
        $Inscripcion->insertar_telefono($idpersonapadre, $celular_padre, 'M') or $sw = FALSE;
      } else {
        $Inscripcion->eliminar_telefono($idpersonapadre, 'M') or $sw = FALSE;
      }
      
      #Se registra el representante
      $idpadre = $Inscripcion->insertar_representante($idpersonapadre, NULL, $oficio_padre) or $sw = FALSE;
      // Cuando la persona ya estaba registrada y el representante también
    } 
    else {
      #Se obtiene el id de la persona 
      $idpersonapadre = $Inscripcion->idpersona($idpadre);
      $idpersonapadre = $idpersonapadre['idpersona'];
      
      #Se editan los datos de la persona
      $Inscripcion->editar_persona($idpersonapadre, $cedula_padre, $p_nombre_padre, $s_nombre_padre, $p_apellido_padre, $s_apellido_padre, 'M') or $sw = FALSE;
      
      if ($Inscripcion->verificar_direccion_residencial($idpersonapadre)) {
        $Inscripcion->editar_direccion_residencial($idpersonapadre,  $direccion_residencia_padre) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_residencial($idpersonapadre, 'NULL', $direccion_residencia_padre) or $sw = FALSE;
      }
      
      if ($Inscripcion->verificar_direccion_trabajo($idpersonapadre)) {
        $Inscripcion->editar_direccion_trabajo($idpersonapadre, $direccion_trabajo_padre) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_trabajo($idpersonapadre, 'NULL', $direccion_trabajo_padre) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_padre)) {
        $Inscripcion->eliminar_telefono($idpersonapadre, 'M') or $sw = FALSE;
        $Inscripcion->insertar_telefono($idpersonapadre, $celular_padre, 'M') or $sw = FALSE;
      } else {
        $Inscripcion->eliminar_telefono($idpersonapadre, 'M') or $sw = FALSE;
      }
      
      #Se edita el representante
      $rspta = $Inscripcion->editar_representante($idpersonapadre, $oficio_padre) or $sw = FALSE;
    }
    
    
   
    
    /**
     * Operaciones relacionadas con el registro, actualización del representante
     */
    if (empty($tiporepresentante)) {
      if (empty($idrepresentante) && empty($idpersonarepresentante)) {
        $idpersonarepresentante = $Inscripcion->insertar_persona($cedula_representante, $p_nombre_representante, $s_nombre_representante, $p_apellido_representante, $s_apellido_representante, $genero_representante) or $sw = FALSE;
        
        $Inscripcion->insertar_direccion_residencial($idpersonarepresentante, 'NULL', $direccion_residencia_representante) or $sw = FALSE;
        
        $Inscripcion->insertar_direccion_trabajo($idpersonarepresentante, 'NUll', $direccion_trabajo_representante) or $sw = FALSE;
        
        #Verifica que las variables de los teléfonos contengan datos y los guarda
        if (!empty($celular_representante))
        $Inscripcion->insertar_telefono($idpersonarepresentante, $celular_representante, 'M') or $sw = FALSE;
        
        #Se registra el representante
        $idrepresentante = $Inscripcion->insertar_representante($idpersonarepresentante, NULL, $oficio_representante) or $sw = FALSE;
      }
      // Cuando la persona ya estaba registrada pero no como representante
      else if (!empty($idpersonarepresentante) && empty($idrepresentante)) {
        #Se editan los datos de la persona
        $Inscripcion->editar_persona($idpersonarepresentante, $cedula_representante, $p_nombre_representante, $s_nombre_representante, $p_apellido_representante, $s_apellido_representante) or $sw = FALSE;
        
        if ($Inscripcion->verificar_direccion_residencial($idpersonarepresentante)) {
          $Inscripcion->editar_direccion_residencial($idpersonarepresentante,  $direccion_residencia_representante) or $sw = FALSE;
        } else {
          $Inscripcion->insertar_direccion_residencial($idpersonarepresentante, 'NULL', $direccion_residencia_representante) or $sw = FALSE;
        }
        
        if ($Inscripcion->verificar_direccion_trabajo($idpersonarepresentante)) {
          $Inscripcion->editar_direccion_trabajo($idpersonarepresentante, $direccion_trabajo_representante) or $sw = FALSE;
        } else {
          $Inscripcion->insertar_direccion_trabajo($idpersonarepresentante, 'NULL', $direccion_trabajo_representante) or $sw = FALSE;
        }
        
        #Verifica que las variables de los teléfonos contengan datos y los guarda
        if (!empty($celular_representante)) {
          $Inscripcion->eliminar_telefono($idpersonarepresentante, 'M') or $sw = FALSE;
          $Inscripcion->insertar_telefono($idpersonarepresentante, $celular_representante, 'M') or $sw = FALSE;
        } else {
          $Inscripcion->eliminar_telefono($idpersonarepresentante, 'M') or $sw = FALSE;
        }
        
        #Se registra el representante
        $idrepresentante = $Inscripcion->insertar_representante($idpersonarepresentante, NULL, $oficio_representante) or $sw = FALSE;
      } else {
        #Se obtiene el id de la persona 
        $idpersonarepresentante = $Inscripcion->idpersona($idrepresentante);
        $idpersonarepresentante = $idpersonarepresentante['idpersona'];
        
        #Se editan los datos de la persona
        $Inscripcion->editar_persona($idpersonarepresentante, $cedula_representante, $p_nombre_representante, $s_nombre_representante, $p_apellido_representante, $s_apellido_representante) or $sw = FALSE;
        
        if ($Inscripcion->verificar_direccion_residencial($idpersonarepresentante)) {
          $Inscripcion->editar_direccion_residencial($idpersonarepresentante,  $direccion_residencia_representante) or $sw = FALSE;
        } else {
          $Inscripcion->insertar_direccion_residencial($idpersonarepresentante, 'NULL', $direccion_residencia_representante) or $sw = FALSE;
        }
        
        if ($Inscripcion->verificar_direccion_trabajo($idpersonarepresentante)) {
          $Inscripcion->editar_direccion_trabajo($idpersonarepresentante, $direccion_trabajo_representante) or $sw = FALSE;
        } else {
          $Inscripcion->insertar_direccion_trabajo($idpersonarepresentante, 'NULL', $direccion_trabajo_representante) or $sw = FALSE;
        }
        
        #Verifica que las variables de los teléfonos contengan datos y los guarda
        if (!empty($celular_representante)) {
          $Inscripcion->eliminar_telefono($idpersonarepresentante, 'M') or $sw = FALSE;
          $Inscripcion->insertar_telefono($idpersonarepresentante, $celular_representante, 'M') or $sw = FALSE;
        } else {
          $Inscripcion->eliminar_telefono($idpersonarepresentante, 'M') or $sw = FALSE;
        }
        
        #Se edita el representante
        $rspta = $Inscripcion->editar_representante($idpersonarepresentante, $oficio_representante) or $sw = FALSE;
      }
    }
    else {
      if($tiporepresentante == 'madre')
      $idrepresentante = $idmadre;
      else if($tiporepresentante == 'padre')
      $idrepresentante = $idpadre;
    }
    
    
    /**
     * Operaciones relacionadas con el estudiante
     */
    #Si la variable esta vacía quiere decir que es un nuevo registro
    $idpersonaestudiante = $Inscripcion->comprobarpersona($cedula_estudiante, FALSE);
    $idpersonaestudiante = !empty($idpersonaestudiante) ? $idpersonaestudiante['id'] : NULL; 
    
    $idestudiante = $Inscripcion->comprobarestudiante($cedula_estudiante);
    $idestudiante = !empty($idestudiante) ? $idestudiante['id'] : NULL;
    
    
    if (empty($idestudiante) && empty($idpersonaestudiante)) {
      
      
      $idpersonaestudiante = $Inscripcion->insertar_persona($cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante, $genero_estudiante, $f_nac_estudiante) or $sw = FALSE;
      
      #Se registra el estudiante
      $idestudiante = $Inscripcion->insertar_estudiante($idpersonaestudiante, $idpersonamadre, $idpersonapadre, $parto, $orden, 'INSCRITO') or $sw = FALSE;
      
      #Se registra el lugar de nacimiento del estudiante
      $Inscripcion->insertar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;
      
    }
    // Cuando la persona ya estaba registrada pero no como estudiante
    else if (!empty($idpersonaestudiante) && empty($idestudiante)) {
      
      $Inscripcion->editar_persona($idpersonaestudiante, $cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante) or $sw = FALSE;
      
      $idestudiante = $Inscripcion->insertar_estudiante($idpersonaestudiante, $idpersonamadre, $idpersonapadre, $parto, $orden, 'INSCRITO') or $sw = FALSE;
      
      if ($Inscripcion->verificar_lugar_nacimiento($idestudiante)) {
        #Se edita el lugar de nacimiento del estudiante
        $Inscripcion->editar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;
      } else {
        #Se registra el lugar de nacimiento del estudiante
        $Inscripcion->insertar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;
      }
      
    } 
    else {
      // Se editan los datos de la persona 
      $Inscripcion->editar_persona_estudiante($idpersonaestudiante, $cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante, $genero_estudiante, $f_nac_estudiante) or $sw = FALSE;
      
      $Inscripcion->editar_estudiante($idpersonaestudiante, $idpersonamadre, $idpersonapadre, $parto, $orden, 'INSCRITO') or $sw = FALSE;
      
      if ($Inscripcion->verificar_lugar_nacimiento($idestudiante)) {
        #Se edita el lugar de nacimiento del estudiante
        $Inscripcion->editar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;
      } else {
        #Se registra el lugar de nacimiento del estudiante
        $Inscripcion->insertar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;
      }
    }
    

    /**
     * Operaciones relacionadas con la inscripción
     */     
    #Se trae el id del período escolar en curso
    $idperiodo_escolar = $Inscripcion->consultarperiodo() or $sw = FALSE;
    $idperiodo_escolar = $idperiodo_escolar['id'];

    #Se comprueba que haya cupo disponible en la planificación
    $cupo_disponible = $Inscripcion->verificarcupo($idplanificacion, 'cupo_disponible') or $sw = FALSE;
    $cupo_disponible = $cupo_disponible['cupo_disponible'];
    
    if($cupo_disponible == 0)
      $sw = FALSE;
    
    $cupo_disponible = ($cupo_disponible - 1);

    #Método para restar un cupo a la planificación
    $Inscripcion->restarcupo($idplanificacion, $cupo_disponible) or $sw = FALSE;
    
    #Se registra la inscripción
    $idinscripcion = $Inscripcion->inscribir($idperiodo_escolar, $idplanificacion, $idestudiante, $idrepresentante, $parentesco_representante, $plantel_procedencia_estudiante, $observaciones, 'CURSANDO') or $sw = FALSE;
   
    
    /**
     * Operaciones relacionadas con los documentos consignados
     */
    $Inscripcion->registrar_documentos_consignados($idinscripcion, $fotocopia_cedula_madre, $fotocopia_cedula_padre, $fotocopia_cedula_representante, $fotos_representante, $fotocopia_partida_nacimiento, $fotocopia_cedula_estudiante, $fotocopia_constancia_vacunas, $fotos_estudiante, $boleta_promocion, $constancia_buena_conducta, $informe_descriptivo) or $sw = FALSE;
 
    #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
    if ($sw) {
      commit();
      echo 'true';
    } else {
      rollback();
      echo 'false';
    }

  break;
        
  case 'listar':
    
    // Se determina el rol que tiene el usuario
    $rol_usuario = isset($_SESSION) ? $_SESSION['rol'] : '';
    $id_usuario = isset($_SESSION) ? $_SESSION['idusuario'] : '';

    $id_docente = $Inscripcion->traerpersonal($id_usuario);
    $id_docente = !empty($id_docente) ? $id_docente['id'] : '';

    if ($rol_usuario == 'Docente') {

      $rspta = $Inscripcion->listarPlanificacionActiva($id_docente);
  
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

        $rspta = $Inscripcion->listarPlanificacionPlanificada($id_docente);

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
      $rspta = $Inscripcion->listarPlanificacionActiva();
    
      
      if ($rspta->num_rows != 0) {

        while ($reg = $rspta->fetch_object()) {
            
          $percentage = ($reg->cupo_disponible * 100) / $reg->cupo;
          $percentage = 100 - $percentage;
          $percentage_color = ($percentage >= 50 && $percentage < 75) ? 'bg-warning' 
          : ($percentage >= 75) ? 'bg-danger' 
          : 'bg-success';
          
          $data[] = array(
              '0' => 

              ( ( isset($_SESSION['permisos']['inscripcion']) && 
                  in_array('ver' , $_SESSION['permisos']['inscripcion']) ) ?
              
              '<button class="btn btn-outline-primary " title="Ver sección" onclick="mostrar(' . $reg->id . ')" data-toggle="modal" data-target="#estudiantesSeccionModal"><i class="fas fa-eye"></i></button> '.

              ( ($reg->cupo_disponible > 0) ?  

              '<a target="_blank" href="../../reporte/disponibilidad-cupo.php?grado='.$reg->grado.'"> <button class="btn btn-primary" title="Disponibilidad de cupo"><i class="fa fa-file-medical"></i></button></a> ' : '') : ''),
              
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

      } 
      else {

        $rspta = $Inscripcion->listarPlanificacionPlanificada();


        if ($rspta->num_rows != 0) {

          while ($reg = $rspta->fetch_object()) {
              
            $percentage = ($reg->cupo_disponible * 100) / $reg->cupo;
            $percentage = 100 - $percentage;
            $percentage_color = ($percentage >= 50 && $percentage < 75) ? 'bg-warning' 
            : ($percentage >= 75) ? 'bg-danger' 
            : 'bg-success';
            
            $data[] = array(
                '0' => 

                ( ( isset($_SESSION['permisos']['inscripcion']) && 
                    in_array('ver' , $_SESSION['permisos']['inscripcion']) ) ?
                
                '<button class="btn btn-outline-primary " title="Ver sección" onclick="mostrar(' . $reg->id . ')" data-toggle="modal" data-target="#estudiantesSeccionModal"><i class="fas fa-eye"></i></button> '.

                ( ($reg->cupo_disponible > 0) ?  

                '<a target="_blank" href="../../reporte/disponibilidad-cupo.php?grado='.$reg->grado.'"> <button class="btn btn-primary" title="Disponibilidad de cupo"><i class="fa fa-file-medical"></i></button></a> ' : '') : ''),
                
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
    echo json_encode($results);
  break;
        
  case 'mostrar':
    $idplanificacion = isset($_GET['idplanificacion']) ? limpiarCadena($_GET['idplanificacion']) : '';
    $rspta = $Inscripcion->mostrar($idplanificacion);
            
    $data = array();
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {
          $data[] = [
              '0' => '',
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
        
  case 'comprobarinscripcion':
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : NULL;
    $rspta = $Inscripcion->comprobarinscripcion($cedula);
    echo json_encode($rspta);    
  break;
        
  case 'comprobarrepresentante':     
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : NULL;
    $genero = isset($_POST['genero']) ? $_POST['genero'] : NULL;
    $rspta = $Inscripcion->comprobarrepresentante($cedula, $genero);
    echo json_encode($rspta);
  break;

  case 'comprobarpersona':
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : NULL;
    $genero = isset($_POST['genero']) ? $_POST['genero'] : NULL;
    $rspta = $Inscripcion->comprobarpersona($cedula, $genero);
    echo json_encode($rspta);
  break;

  case 'traerplanificaciones':   
    #Traer la planificaciones disponibles

    // Se determina el rol que tiene el usuario
    $rol_usuario = isset($_SESSION) ? $_SESSION['rol'] : '';
    $id_usuario = isset($_SESSION) ? $_SESSION['idusuario'] : '';

    $id_docente = $Inscripcion->traerpersonal($id_usuario);
    $id_docente = !empty($id_docente) ? $id_docente['id'] : '';

    if ($rol_usuario == 'Docente') {
      $rspta = $Inscripcion->traerplanificaciones($id_docente);    
      $data = array();
      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {    
          $data[] = [
            'id' => $reg->id,
            'grado' => $reg->grado,
            'seccion' => $reg->seccion,
            'cupo_disponible' => $reg->cupo_disponible
          ];
        }
      }
    }
    else {
      $rspta = $Inscripcion->traerplanificaciones();    
      $data = array();
      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {    
          $data[] = [
            'id' => $reg->id,
            'grado' => $reg->grado,
            'seccion' => $reg->seccion,
            'cupo_disponible' => $reg->cupo_disponible
          ];
        }
      }
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
  break;

  case 'listarpaises':
    $rspta = $Inscripcion->listarpaises();

    while ($pais = $rspta->fetch_object()) {
      // $selected = $pais->pais == 'Venezuela' ? 'selected' : '';
      echo '<option value="' . $pais->id . '">' . $pais->pais . '</option>';
    }
  break;

  case 'listarestados':
    $idpais = isset($_GET['idpais']) ? $_GET['idpais'] : NULL;
    $rspta = $Inscripcion->listarestados($idpais);

    while ($estado = $rspta->fetch_object()) {
      echo '<option value="' . $estado->id . '">' . $estado->estado . '</option>';
    }
  break;

  case 'listarmunicipios':
    $idestado = isset($_GET['idestado']) ? $_GET['idestado'] : NULL;
    $rspta = $Inscripcion->listarmunicipios($idestado);

    while ($municipio = $rspta->fetch_object()) {
      echo '<option value="' . $municipio->id . '">' . $municipio->municipio . '</option>';
    }
  break;

  case 'listarparroquias':
    $idmunicipio = isset($_GET['idmunicipio']) ? $_GET['idmunicipio'] : NULL;
    $rspta = $Inscripcion->listarparroquias($idmunicipio);

    while ($parroquia = $rspta->fetch_object()) {
      echo '<option value="' . $parroquia->id . '">' . $parroquia->parroquia . '</option>';
    }
  break;

  case 'listadoinscripcionregular':
  
    $rspta = $Inscripcion->listadoinscripcionregular();
    
    $data = [];
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {
        if ($reg->estatus != 'CURSANDO') {
          $data[] = array(
              '0' =>          
              '<button class="btn btn-outline-primary " title="Inscribir" onclick="mostrarInscripcionRegular(' . $reg->idinscripcion. ', '. $reg->grado .', \''. $reg->seccion .'\', \''.$reg->estatus.'\', '.$reg->idestudiante.')" data-toggle="modal" data-target="#inscripcionRegularModal"><i class="fas fa-sign-in-alt"></i></button>'           
              ,
  
              '1' => $reg->cedula,
              '2' => ucfirst($reg->p_nombre),
              '3' => ucfirst($reg->p_apellido),
              '4' => $reg->grado . ' º "'.$reg->seccion.'" - '.$reg->periodo,
              '5' => $reg->estatus
          );
        }
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

  case 'traerrepresentanteregular': 
 
    $rspta = $Inscripcion->traerrepresentanteregular($idinscripcionregular);
    echo json_encode($rspta);
  break;

  case 'traersiguienteperiodo':    
    $periodoinscripcion = $Inscripcion->traerperiodoinscripcion($idinscripcionregular);
    $periodoinscripcion = !empty($periodoinscripcion) ? $periodoinscripcion['periodo'] : '';

    list($primero, $segundo) = explode('-',$periodoinscripcion);
    
    $siguiente_periodo = ($primero + 1).'-'.($segundo + 1);
    
    $datos_siguiente_periodo = $Inscripcion->traersiguienteperiodo($siguiente_periodo);
    
    echo json_encode($datos_siguiente_periodo);
  break;

  case 'traerplanificacionregular':   
    $grado = ($estatus_regular == 'PROMOVIDO') ? ($grado_regular + 1) : $grado_regular;
     
    $planificacion = $Inscripcion->traerplanificacionregular($idsiguienteperiodo, $grado);

    $data = array();
    if ($planificacion->num_rows != 0) {
      while ($reg = $planificacion->fetch_object()) {    
        $data[] = [
          'id' => $reg->id,
          'grado' => $reg->grado,
          'seccion' => $reg->seccion,
          'p_nombre' => ucwords($reg->p_nombre),
          'p_apellido' => ucwords($reg->p_apellido),
          'cupo_disponible' => $reg->cupo_disponible
        ];
      }
    }
    
    echo json_encode($data);
  break;

  case 'inscribir_regular':
    #Se deshabilita el guardado automático de la base de datos
    autocommit(FALSE);
    #Variable para comprobar que todo salió bien al final
    $sw = TRUE;
    
    /**
     * Operaciones relacionadas con el registro, actualización del representante
     */
    if (empty($idrepresentante_regular) && empty($idpersonarepresentante_regular)) {
      $idpersonarepresentante_regular = $Inscripcion->insertar_persona($cedula_representante_regular, $p_nombre_representante_regular, $s_nombre_representante_regular, $p_apellido_representante_regular, $s_apellido_representante_regular, $genero_representante_regular) or $sw = FALSE;
      
      $Inscripcion->insertar_direccion_residencial($idpersonarepresentante_regular, 'NULL', $direccion_residencia_representante_regular) or $sw = FALSE;
      
      $Inscripcion->insertar_direccion_trabajo($idpersonarepresentante_regular, 'NUll', $direccion_trabajo_representante_regular) or $sw = FALSE;
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_representante_regular))
      $Inscripcion->insertar_telefono($idpersonarepresentante_regular, $celular_representante_regular, 'M') or $sw = FALSE;
      
      #Se registra el representante
      $idrepresentante_regular = $Inscripcion->insertar_representante($idpersonarepresentante_regular, NULL, $oficio_representante_regular) or $sw = FALSE;
    }
    // Cuando la persona ya estaba registrada pero no como representante
    else if (!empty($idpersonarepresentante_regular) && empty($idrepresentante_regular)) {
      #Se editan los datos de la persona
      $Inscripcion->editar_persona($idpersonarepresentante_regular, $cedula_representante_regular, $p_nombre_representante_regular, $s_nombre_representante_regular, $p_apellido_representante_regular, $s_apellido_representante_regular) or $sw = FALSE;

      if ($Inscripcion->verificar_direccion_residencial($idpersonarepresentante_regular)) {
        $Inscripcion->editar_direccion_residencial($idpersonarepresentante_regular,  $direccion_residencia_representante_regular) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_residencial($idpersonarepresentante_regular, 'NULL', $direccion_residencia_representante_regular) or $sw = FALSE;
      }
      
      if ($Inscripcion->verificar_direccion_trabajo($idpersonarepresentante_regular)) {
        $Inscripcion->editar_direccion_trabajo($idpersonarepresentante_regular, $direccion_trabajo_representante_regular) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_trabajo($idpersonarepresentante_regular, 'NULL', $direccion_trabajo_representante_regular) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_representante_regular)) {
        $Inscripcion->eliminar_telefono($idpersonarepresentante_regular, 'M') or $sw = FALSE;
        $Inscripcion->insertar_telefono($idpersonarepresentante_regular, $celular_representante_regular, 'M') or $sw = FALSE;
      } else {
        $Inscripcion->eliminar_telefono($idpersonarepresentante_regular, 'M') or $sw = FALSE;
      }
      
      #Se registra el representante
      $idrepresentante_regular = $Inscripcion->insertar_representante($idpersonarepresentante_regular, NULL, $oficio_representante_regular) or $sw = FALSE;
    } else {
      #Se obtiene el id de la persona 
      $idpersonarepresentante_regular = $Inscripcion->idpersona($idrepresentante_regular);
      $idpersonarepresentante_regular = $idpersonarepresentante_regular['idpersona'];
      
      #Se editan los datos de la persona
      $Inscripcion->editar_persona($idpersonarepresentante_regular, $cedula_representante_regular, $p_nombre_representante_regular, $s_nombre_representante_regular, $p_apellido_representante_regular, $s_apellido_representante_regular) or $sw = FALSE;
      
      if ($Inscripcion->verificar_direccion_residencial($idpersonarepresentante_regular)) {
        $Inscripcion->editar_direccion_residencial($idpersonarepresentante_regular,  $direccion_residencia_representante_regular) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_residencial($idpersonarepresentante_regular, 'NULL', $direccion_residencia_representante_regular) or $sw = FALSE;
      }
      
      if ($Inscripcion->verificar_direccion_trabajo($idpersonarepresentante_regular)) {
        $Inscripcion->editar_direccion_trabajo($idpersonarepresentante_regular, $direccion_trabajo_representante_regular) or $sw = FALSE;
      } else {
        $Inscripcion->insertar_direccion_trabajo($idpersonarepresentante_regular, 'NULL', $direccion_trabajo_representante_regular) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_representante_regular)) {
        $Inscripcion->eliminar_telefono($idpersonarepresentante_regular, 'M') or $sw = FALSE;
        $Inscripcion->insertar_telefono($idpersonarepresentante_regular, $celular_representante_regular, 'M') or $sw = FALSE;
      } else {
        $Inscripcion->eliminar_telefono($idpersonarepresentante_regular, 'M') or $sw = FALSE;
      }
      
      #Se edita el representante
      $rspta = $Inscripcion->editar_representante($idpersonarepresentante_regular, $oficio_representante_regular) or $sw = FALSE;
    }   
    
    /**
     * Operaciones relacionadas con la inscripción
     */     

    #Se comprueba que haya cupo disponible en la planificación
    $cupo_disponible = $Inscripcion->verificarcupo($idplanificacion_regular, 'cupo_disponible') or $sw = FALSE;
    $cupo_disponible = $cupo_disponible['cupo_disponible'];
    
    if($cupo_disponible == 0)
      $sw = FALSE;
    
    $cupo_disponible = ($cupo_disponible - 1);

    #Método para restar un cupo a la planificación
    $Inscripcion->restarcupo($idplanificacion_regular, $cupo_disponible) or $sw = FALSE;
    
    $nombre_institucion = $Inscripcion->traerdatosinstitucion();
    $nombre_institucion = !empty($nombre_institucion) ? $nombre_institucion['nombre'] : 'Escuela Básica Miguel Otero Silva';


    #Se registra la inscripción
    $idinscripcion_regular = $Inscripcion->inscribir($idperiodo_escolar_regular, $idplanificacion_regular, $idestudiante_regular, $idrepresentante_regular, $parentesco_representante_regular, $nombre_institucion, $observaciones_regular, 'CURSANDO') or $sw = FALSE;
 
    #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
    if ($sw) {
      commit();
      echo 'true';
    } else {
      rollback();
      echo 'false';
    }

  break;
  

}
