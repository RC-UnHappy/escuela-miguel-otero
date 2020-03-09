<?php

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start();

#Se incluye el modelo de inscripción Inicial
require_once '../../modelos/inscripcion/Inicial.php';
#Se instancia el objeto de inscripción Incial
$Inicial = new Inicial;

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
$repite = isset($_POST['repite']) ? limpiarCadena($_POST['repite']) : '';
$observaciones = isset($_POST['observaciones']) ? limpiarCadena($_POST['observaciones']) : '';

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
      $idpersonamadre = $Inicial->insertar_persona($cedula_madre, $p_nombre_madre, $s_nombre_madre, $p_apellido_madre, $s_apellido_madre, 'F') or $sw = FALSE;
      
      $Inicial->insertar_direccion_residencial($idpersonamadre, 'NULL', $direccion_residencia_madre) or $sw = FALSE;

      
      $Inicial->insertar_direccion_trabajo($idpersonamadre, 'NUll', $direccion_trabajo_madre) or $sw = FALSE;
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_madre))
      $Inicial->insertar_telefono($idpersonamadre, $celular_madre, 'M') or $sw = FALSE;
      
      #Se registra el representante
      $idmadre = $Inicial->insertar_representante($idpersonamadre, NULL, $oficio_madre) or $sw = FALSE;
    }
    // Cuando la persona ya estaba registrada pero no como representante
    else if(!empty($idpersonamadre) && empty($idmadre)) {
      #Se editan los datos de la persona
      $Inicial->editar_persona($idpersonamadre, $cedula_madre, $p_nombre_madre, $s_nombre_madre, $p_apellido_madre, $s_apellido_madre, 'F') or $sw = FALSE;
      
      if ($Inicial->verificar_direccion_residencial($idpersonamadre)) {
        $Inicial->editar_direccion_residencial($idpersonamadre,  $direccion_residencia_madre) or $sw = FALSE;
      } else {
        $Inicial->insertar_direccion_residencial($idpersonamadre, 'NULL', $direccion_residencia_madre) or $sw = FALSE;
      }
      
      if ($Inicial->verificar_direccion_trabajo($idpersonamadre)) {
        $Inicial->editar_direccion_trabajo($idpersonamadre, $direccion_trabajo_madre) or $sw = FALSE;
      } else {
        $Inicial->insertar_direccion_trabajo($idpersonamadre, 'NULL', $direccion_trabajo_madre) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_madre)) {
        $Inicial->eliminar_telefono($idpersonamadre, 'M') or $sw = FALSE;
        $Inicial->insertar_telefono($idpersonamadre, $celular_madre, 'M') or $sw = FALSE;
      } else {
        $Inicial->eliminar_telefono($idpersonamadre, 'M') or $sw = FALSE;
      }
      
      #Se registra el representante
      $idmadre = $Inicial->insertar_representante($idpersonamadre, NULL, $oficio_madre) or $sw = FALSE;
    }
    else {
      #Se obtiene el id de la persona 
      $idpersonamadre = $Inicial->idpersona($idmadre);
      $idpersonamadre = $idpersonamadre['idpersona'];
      
      #Se editan los datos de la persona
      $Inicial->editar_persona($idpersonamadre, $cedula_madre, $p_nombre_madre, $s_nombre_madre, $p_apellido_madre, $s_apellido_madre, 'F') or $sw = FALSE;
      
      if ($Inicial->verificar_direccion_residencial($idpersonamadre)) {
        $Inicial->editar_direccion_residencial($idpersonamadre,  $direccion_residencia_madre) or $sw = FALSE;
      } else {
        $Inicial->insertar_direccion_residencial($idpersonamadre, 'NULL', $direccion_residencia_madre) or $sw = FALSE;
      }
      
      if ($Inicial->verificar_direccion_trabajo($idpersonamadre)) {
        $Inicial->editar_direccion_trabajo($idpersonamadre, $direccion_trabajo_madre) or $sw = FALSE;
      } else {
        $Inicial->insertar_direccion_trabajo($idpersonamadre, 'NULL', $direccion_trabajo_madre) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_madre)) {
        $Inicial->eliminar_telefono($idpersonamadre, 'M') or $sw = FALSE;
        $Inicial->insertar_telefono($idpersonamadre, $celular_madre, 'M') or $sw = FALSE;
      } else {
        $Inicial->eliminar_telefono($idpersonamadre, 'M') or $sw = FALSE;
      }
      
      #Se edita el representante
      $rspta = $Inicial->editar_representante($idpersonamadre, $oficio_madre) or $sw = FALSE;
      
    }
    
    /**
     * Operaciones relacionadas con el registro, actualización del padre
     */
    if (empty($idpadre) && empty($idpersonapadre)) {
      $idpersonapadre = $Inicial->insertar_persona($cedula_padre, $p_nombre_padre, $s_nombre_padre, $p_apellido_padre, $s_apellido_padre, 'M') or $sw = FALSE;
      
      $Inicial->insertar_direccion_residencial($idpersonapadre, 'NULL', $direccion_residencia_padre) or $sw = FALSE;
      
      $Inicial->insertar_direccion_trabajo($idpersonapadre, 'NUll', $direccion_trabajo_padre) or $sw = FALSE;
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_padre))
      $Inicial->insertar_telefono($idpersonapadre, $celular_padre, 'M') or $sw = FALSE;
      
      #Se registra el representante
      $idpadre = $Inicial->insertar_representante($idpersonapadre, NULL, $oficio_padre) or $sw = FALSE;
    }
    // Cuando la persona ya estaba registrada pero no como representante
    else if (!empty($idpersonapadre) && empty($idpadre)) {
      #Se editan los datos de la persona
      $Inicial->editar_persona($idpersonapadre, $cedula_padre, $p_nombre_padre, $s_nombre_padre, $p_apellido_padre, $s_apellido_padre, 'M') or $sw = FALSE;

      if ($Inicial->verificar_direccion_residencial($idpersonapadre)) {
        $Inicial->editar_direccion_residencial($idpersonapadre,  $direccion_residencia_padre) or $sw = FALSE;
      } else {
        $Inicial->insertar_direccion_residencial($idpersonapadre, 'NULL', $direccion_residencia_padre) or $sw = FALSE;
      }
      
      if ($Inicial->verificar_direccion_trabajo($idpersonapadre)) {
        $Inicial->editar_direccion_trabajo($idpersonapadre, $direccion_trabajo_padre) or $sw = FALSE;
      } else {
        $Inicial->insertar_direccion_trabajo($idpersonapadre, 'NULL', $direccion_trabajo_padre) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_padre)) {
        $Inicial->eliminar_telefono($idpersonapadre, 'M') or $sw = FALSE;
        $Inicial->insertar_telefono($idpersonapadre, $celular_padre, 'M') or $sw = FALSE;
      } else {
        $Inicial->eliminar_telefono($idpersonapadre, 'M') or $sw = FALSE;
      }
      
      #Se registra el representante
      $idpadre = $Inicial->insertar_representante($idpersonapadre, NULL, $oficio_padre) or $sw = FALSE;
      // Cuando la persona ya estaba registrada y el representante también
    } 
    else {
      #Se obtiene el id de la persona 
      $idpersonapadre = $Inicial->idpersona($idpadre);
      $idpersonapadre = $idpersonapadre['idpersona'];
      
      #Se editan los datos de la persona
      $Inicial->editar_persona($idpersonapadre, $cedula_padre, $p_nombre_padre, $s_nombre_padre, $p_apellido_padre, $s_apellido_padre, 'M') or $sw = FALSE;
      
      if ($Inicial->verificar_direccion_residencial($idpersonapadre)) {
        $Inicial->editar_direccion_residencial($idpersonapadre,  $direccion_residencia_padre) or $sw = FALSE;
      } else {
        $Inicial->insertar_direccion_residencial($idpersonapadre, 'NULL', $direccion_residencia_padre) or $sw = FALSE;
      }
      
      if ($Inicial->verificar_direccion_trabajo($idpersonapadre)) {
        $Inicial->editar_direccion_trabajo($idpersonapadre, $direccion_trabajo_padre) or $sw = FALSE;
      } else {
        $Inicial->insertar_direccion_trabajo($idpersonapadre, 'NULL', $direccion_trabajo_padre) or $sw = FALSE;
      }
      
      #Verifica que las variables de los teléfonos contengan datos y los guarda
      if (!empty($celular_padre)) {
        $Inicial->eliminar_telefono($idpersonapadre, 'M') or $sw = FALSE;
        $Inicial->insertar_telefono($idpersonapadre, $celular_padre, 'M') or $sw = FALSE;
      } else {
        $Inicial->eliminar_telefono($idpersonapadre, 'M') or $sw = FALSE;
      }
      
      #Se edita el representante
      $rspta = $Inicial->editar_representante($idpersonapadre, $oficio_padre) or $sw = FALSE;
    }
    
    
    
    
    /**
     * Operaciones relacionadas con el registro, actualización del representante
     */
    if (empty($tiporepresentante)) {
      if (empty($idrepresentante) && empty($idpersonarepresentante)) {
        $idpersonarepresentante = $Inicial->insertar_persona($cedula_representante, $p_nombre_representante, $s_nombre_representante, $p_apellido_representante, $s_apellido_representante, $genero_representante) or $sw = FALSE;
        
        $Inicial->insertar_direccion_residencial($idpersonarepresentante, 'NULL', $direccion_residencia_representante) or $sw = FALSE;
        
        $Inicial->insertar_direccion_trabajo($idpersonarepresentante, 'NUll', $direccion_trabajo_representante) or $sw = FALSE;
        
        #Verifica que las variables de los teléfonos contengan datos y los guarda
        if (!empty($celular_representante))
        $Inicial->insertar_telefono($idpersonarepresentante, $celular_representante, 'M') or $sw = FALSE;
        
        #Se registra el representante
        $idrepresentante = $Inicial->insertar_representante($idpersonarepresentante, NULL, $oficio_representante) or $sw = FALSE;
      }
      // Cuando la persona ya estaba registrada pero no como representante
      else if (!empty($idpersonarepresentante) && empty($idrepresentante)) {
        #Se editan los datos de la persona
        $Inicial->editar_persona($idpersonarepresentante, $cedula_representante, $p_nombre_representante, $s_nombre_representante, $p_apellido_representante, $s_apellido_representante) or $sw = FALSE;

        if ($Inicial->verificar_direccion_residencial($idpersonarepresentante)) {
          $Inicial->editar_direccion_residencial($idpersonarepresentante,  $direccion_residencia_representante) or $sw = FALSE;
        } else {
          $Inicial->insertar_direccion_residencial($idpersonarepresentante, 'NULL', $direccion_residencia_representante) or $sw = FALSE;
        }
        
        if ($Inicial->verificar_direccion_trabajo($idpersonarepresentante)) {
          $Inicial->editar_direccion_trabajo($idpersonarepresentante, $direccion_trabajo_representante) or $sw = FALSE;
        } else {
          $Inicial->insertar_direccion_trabajo($idpersonarepresentante, 'NULL', $direccion_trabajo_representante) or $sw = FALSE;
        }
        
        #Verifica que las variables de los teléfonos contengan datos y los guarda
        if (!empty($celular_representante)) {
          $Inicial->eliminar_telefono($idpersonarepresentante, 'M') or $sw = FALSE;
          $Inicial->insertar_telefono($idpersonarepresentante, $celular_representante, 'M') or $sw = FALSE;
        } else {
          $Inicial->eliminar_telefono($idpersonarepresentante, 'M') or $sw = FALSE;
        }
        
        #Se registra el representante
        $idrepresentante = $Inicial->insertar_representante($idpersonarepresentante, NULL, $oficio_representante) or $sw = FALSE;
      } else {
        #Se obtiene el id de la persona 
        $idpersonarepresentante = $Inicial->idpersona($idrepresentante);
        $idpersonarepresentante = $idpersonarepresentante['idpersona'];
        
        #Se editan los datos de la persona
        $Inicial->editar_persona($idpersonarepresentante, $cedula_representante, $p_nombre_representante, $s_nombre_representante, $p_apellido_representante, $s_apellido_representante) or $sw = FALSE;
        
        if ($Inicial->verificar_direccion_residencial($idpersonarepresentante)) {
          $Inicial->editar_direccion_residencial($idpersonarepresentante,  $direccion_residencia_representante) or $sw = FALSE;
        } else {
          $Inicial->insertar_direccion_residencial($idpersonarepresentante, 'NULL', $direccion_residencia_representante) or $sw = FALSE;
        }
        
        if ($Inicial->verificar_direccion_trabajo($idpersonarepresentante)) {
          $Inicial->editar_direccion_trabajo($idpersonarepresentante, $direccion_trabajo_representante) or $sw = FALSE;
        } else {
          $Inicial->insertar_direccion_trabajo($idpersonarepresentante, 'NULL', $direccion_trabajo_representante) or $sw = FALSE;
        }
        
        #Verifica que las variables de los teléfonos contengan datos y los guarda
        if (!empty($celular_representante)) {
          $Inicial->eliminar_telefono($idpersonarepresentante, 'M') or $sw = FALSE;
          $Inicial->insertar_telefono($idpersonarepresentante, $celular_representante, 'M') or $sw = FALSE;
        } else {
          $Inicial->eliminar_telefono($idpersonarepresentante, 'M') or $sw = FALSE;
        }
        
        #Se edita el representante
        $rspta = $Inicial->editar_representante($idpersonarepresentante, $oficio_representante) or $sw = FALSE;
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
    $idpersonaestudiante = $Inicial->comprobarpersona($cedula_estudiante, FALSE);
    $idpersonaestudiante = !empty($idpersonaestudiante) ? $idpersonaestudiante['id'] : NULL; 
    
    $idestudiante = $Inicial->comprobarestudiante($cedula_estudiante);
    $idestudiante = !empty($idestudiante) ? $idestudiante['id'] : NULL;
    
    
    if (empty($idestudiante) && empty($idpersonaestudiante)) {
      
      $idpersonaestudiante = $Inicial->insertar_persona($cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante, $genero_estudiante) or $sw = FALSE;
      
      /////////////////////////////////////////////////// Vas por aquí
      #Se registra el estudiante
      $idestudiante = $Inicial->insertar_estudiante($idpersonaestudiante, $idpersonamadre, $idpersonapadre, $parto, $orden, 'INSCRITO') or $sw = FALSE;
        
      #Se registra el lugar de nacimiento del estudiante
      $Inicial->insertar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;

    }
    // Cuando la persona ya estaba registrada pero no como estudiante
    else if (!empty($idpersonaestudiante) && empty($idestudiante)) {
      
      $Inicial->editar_persona($idpersonaestudiante, $cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante) or $sw = FALSE;
      
      $idestudiante = $Inicial->insertar_estudiante($idpersonaestudiante, $idpersonamadre, $idpersonapadre, $parto, $orden, 'INSCRITO') or $sw = FALSE;
      
      if ($Inicial->verificar_lugar_nacimiento($idestudiante)) {
        #Se edita el lugar de nacimiento del estudiante
        $Inicial->editar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;
      } else {
        #Se registra el lugar de nacimiento del estudiante
        $Inicial->insertar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;
      }
      
    } 
    else {
      
      // Se editan los datos de la persona 
      $Inicial->editar_persona($idpersonaestudiante, $cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante) or $sw = FALSE;
      
      $Inicial->editar_estudiante($idpersonaestudiante, $idpersonamadre, $idpersonapadre, $parto, $orden, 'INSCRITO');
      
      if ($Inicial->verificar_lugar_nacimiento($idestudiante)) {
        #Se edita el lugar de nacimiento del estudiante
        $Inicial->editar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;
      } else {
        #Se registra el lugar de nacimiento del estudiante
        $Inicial->insertar_lugar_nacimiento($idestudiante, $parroquia_nacimiento_estudiante) or $sw = FALSE;
      }
    }
    

    /**
     * Operaciones relacionadas con la inscripción
     */     
    #Se trae el id del período escolar en curso
    $idperiodo_escolar = $Inicial->consultarperiodo() or $sw = FALSE;
    $idperiodo_escolar = $idperiodo_escolar['id'];

    #Se comprueba que haya cupo disponible en la planificación
    $cupo_disponible = $Inicial->verificarcupo($idplanificacion, 'cupo_disponible') or $sw = FALSE;
    $cupo_disponible = $cupo_disponible['cupo_disponible'];
    
    if($cupo_disponible == 0)
      $sw = FALSE;
    
    $cupo_disponible = ($cupo_disponible - 1);

    #Método para restar un cupo a la planificación
    $Inicial->restarcupo($idplanificacion, $cupo_disponible) or $sw = FALSE;
    
    #Se registra la inscripción
    $idinscripcion = $Inicial->inscribir($idperiodo_escolar, $idplanificacion, $idestudiante, $idrepresentante, $parentesco_representante, $plantel_procedencia_estudiante, $repite, $observaciones, '1') or $sw = FALSE;
   
    
    /**
     * Operaciones relacionadas con los documentos consignados
     */
    $Inicial->registrar_documentos_consignados($idinscripcion, $fotocopia_cedula_madre, $fotocopia_cedula_padre, $fotocopia_cedula_representante, $fotos_representante, $fotocopia_partida_nacimiento, $fotocopia_cedula_estudiante, $fotocopia_constancia_vacunas, $fotos_estudiante, $boleta_promocion, $constancia_buena_conducta, $informe_descriptivo) or $sw = FALSE;
 
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
        
  case 'comprobarinscripcion':
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : NULL;
    $rspta = $Inicial->comprobarinscripcion($cedula);
    echo json_encode($rspta);    
    break;
        
  case 'comprobarrepresentante':     
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : NULL;
    $genero = isset($_POST['genero']) ? $_POST['genero'] : NULL;
    $rspta = $Inicial->comprobarrepresentante($cedula, $genero);
    echo json_encode($rspta);
    break;

  case 'comprobarpersona':
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : NULL;
    $genero = isset($_POST['genero']) ? $_POST['genero'] : NULL;
    $rspta = $Inicial->comprobarpersona($cedula, $genero);
    echo json_encode($rspta);
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
          'cupo_disponible' => $reg->cupo_disponible
        ];
      }
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'listarpaises':
    $rspta = $Inicial->listarpaises();

    while ($pais = $rspta->fetch_object()) {
      // $selected = $pais->pais == 'Venezuela' ? 'selected' : '';
      echo '<option value="' . $pais->id . '">' . $pais->pais . '</option>';
    }
    break;

  case 'listarestados':
    $idpais = isset($_GET['idpais']) ? $_GET['idpais'] : NULL;
    $rspta = $Inicial->listarestados($idpais);

    while ($estado = $rspta->fetch_object()) {
      echo '<option value="' . $estado->id . '">' . $estado->estado . '</option>';
    }
    break;

  case 'listarmunicipios':
    $idestado = isset($_GET['idestado']) ? $_GET['idestado'] : NULL;
    $rspta = $Inicial->listarmunicipios($idestado);

    while ($municipio = $rspta->fetch_object()) {
      echo '<option value="' . $municipio->id . '">' . $municipio->municipio . '</option>';
    }
    break;

  case 'listarparroquias':
    $idmunicipio = isset($_GET['idmunicipio']) ? $_GET['idmunicipio'] : NULL;
    $rspta = $Inicial->listarparroquias($idmunicipio);

    while ($parroquia = $rspta->fetch_object()) {
      echo '<option value="' . $parroquia->id . '">' . $parroquia->parroquia . '</option>';
    }
    break;


}
