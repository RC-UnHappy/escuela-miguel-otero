<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
  header('location: login.html');
} else {
  define('IMAGE_PATH', dirname((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 2) . '/public/img/');
require_once 'modules/header.php';
if (isset($_SESSION['permisos']['estudiante']) && in_array('ver' , $_SESSION['permisos']['estudiante'])) {
?>

<!-- Contenido -->
<main class="main">
  <div class="animated fadeIn">
    <div class="jumbotron jumbotron-fluid mb-0 fondo-degradado">
    </div>
    <div class="container panel-principal col-sm-12">
      <div class="card border-light mb-3 shadow p-3 mb-5 bg-white rounded ">

        <div class="card-header pt-0 pb-1 bg-white mb-3">
          <!-- Botonera del panel -->

          <h1 class="font-weight-normal h5">Estudiante

            <?php              
              if( isset($_SESSION['permisos']['estudiante']) && 
                  in_array('agregar' , $_SESSION['permisos']['estudiante']) ){
                echo 
                '<button class="btn btn-outline-primary btn-pill shadow-sm" onclick="mostrarform(true)" id="btnagregar">
                  <i class="fa fa-plus-circle"></i> Agregar
                </button>';
              }       
            ?> 
            
          </h1>
        </div>

        <div class="row" id="listadoregistros">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-borderless table-striped" id="tblistado">
                <caption>Lista de estudiantes</caption>
                <thead class="fondo-degradado text-white">
                  <tr>
                    <th scope="col">Opciones</th>
                    <th scope="col">Cédula</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Cédula Madre</th>
                    <th scope="col">Cédula Padre</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <form class="needs-validation" novalidate name="estudiante" id="formularioregistros">
          <!-- Formulario de estudiante -->
          <div class="row">

            <div class="col-sm-12">
              <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-5 bg-white rounded">
                <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                  <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-user-edit"></i> Personales
                    <small class="text-dark">(Requerido)</small>
                  </h5>
                </div>

                <div class="card-body">

                  <div class="row">

                    <div class="form-group col-md-3">
                      <label for="documento_madre">Cédula de la madre (*)</label>
                      <div class="input-group ">
                        <div class="input-group-prepend">
                          <select name="documento_madre" id="documento_madre" class="form-control selectpicker" required="true">
                            <option value="">Seleccione</option>
                            <option value="venezolano">Venezolano</option>
                            <option value="extranjero">Extranjero</option>
                            <option value="pasaporte">Pasaporte</option>
                          </select>
                        </div>

                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula_madre" id="cedula_madre" maxlength="8" minlength="7" required>

                        <input type="hidden" name="idmadre" id="idmadre"> <!-- Input oculto que guardará el id de la madre -->
                        <div class="invalid-feedback" id="feedback-cedula-madre">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="documento_padre">Cédula del padre</label>
                      <div class="input-group ">
                        <div class="input-group-prepend">
                          <select name="documento_padre" id="documento_padre" class="form-control selectpicker">
                            <option value="">Seleccione</option>
                            <option value="venezolano">Venezolano</option>
                            <option value="extranjero">Extranjero</option>
                            <option value="pasaporte">Pasaporte</option>
                          </select>
                        </div>

                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula_padre" id="cedula_padre" maxlength="8" minlength="7">

                        <input type="hidden" name="idpadre" id="idpadre"> <!-- Input oculto que guardará el id del padre cuando sea necesario -->
                        <div class="invalid-feedback" id="feedback-cedula-padre">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="documento">Documento del estudiante (*)</label>
                      <div class="input-group ">
                        <select name="documento" id="documento" class="form-control selectpicker" required="true">
                          <option value="">Seleccione</option>
                          <option value="venezolano">Venezolano</option>
                          <option value="extranjero">Extranjero</option>
                          <option value="cedula_estudiantil">Cédula Estudiantil</option>
                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="cedula">Cédula del estudiante (*)</label>
                      <div class="input-group">

                        <input type="hidden" name="idestudiante" id="idestudiante"> <!-- Input oculto que guardará el id del estudiante cuando sea necesario -->

                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula" id="cedula" maxlength="8" minlength="7" required>

                        <div class="invalid-feedback" id="mensajeCedula">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="p_nombre">Primer Nombre (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="p_nombre" id="p_nombre" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="s_nombre">Segundo Nombre</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="s_nombre" id="s_nombre">
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="p_apellido">Primer Apellido (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="p_apellido" id="p_apellido" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="s_apellido">Segundo Apellido</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="s_apellido" id="s_apellido">
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="genero">Género (*)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text" id="icono_genero">
                            <i class="fas fa-venus-mars"></i>
                          </div>
                        </div>
                        <select name="genero" class="form-control selectpicker genero" id="genero" required>
                          <option value="">Seleccione</option>
                          <option value="M">Masculino</option>
                          <option value="F">Femenino</option>
                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="f_nac">Fecha Nacimiento (*)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                          </div>
                        </div>
                        <input type="date" name="f_nac" id="f_nac" class="form-control" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="">¿Es parto multiple? (*)</label>
                      <div class="input-group">

                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="partoSi" name="parto" class="custom-control-input" required value="si">
                          <label class="custom-control-label" for="partoSi">Si</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>



                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="partoNo" name="parto" class="custom-control-input" required value="no">
                          <label class="custom-control-label" for="partoNo">No</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="orden">Orden de nacimiento</label>
                      <div class="input-group">

                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 2" name="orden" id="orden" maxlength="1" disabled>

                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="pais_nacimiento">País nacimiento (*)</label>
                      <div class="input-group">
                        <select id="pais_nacimiento" name="pais_nacimiento" class="form-control selectpicker" data-live-search="true" required>
                          <option value="">Seleccione</option>

                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="estado_nacimiento">Estado nacimiento (*)</label>
                      <div class="input-group">
                        <select id="estado_nacimiento" name="estado_nacimiento" class="form-control selectpicker" data-live-search="true" required disabled>
                          <option value="">Seleccione</option>

                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="municipio_nacimiento">Municipio nacimiento (*)</label>
                      <div class="input-group">
                        <select id="municipio_nacimiento" name="municipio_nacimiento" class="form-control selectpicker" data-live-search="true" required disabled>
                          <option value="">Seleccione</option>

                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="parroquia_nacimiento">Parroquia nacimiento (*)</label>
                      <div class="input-group">
                        <select id="parroquia_nacimiento" name="parroquia_nacimiento" class="form-control selectpicker" data-live-search="true" required disabled>
                          <option value="">Seleccione</option>

                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="card border-right-0 border-bottom-0 border-left-0  shadow mb-5 bg-white border-top-0 rounded">
                <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                  <h5 class="m-0 p-0 lead font-italic font-weight-bold text-white"><i class="fas fa-home "></i> Residenciales
                    <small class="text-dark">(Requerido)</small>
                  </h5>
                </div>

                <div class="card-body">
                  <div class="row">

                    <div class="form-group col-md-4">
                      <label for="estado_residencia">Estado de residencia (*)</label>
                      <div class="input-group">
                        <select id="estado_residencia" name="estado_residencia" class="form-control selectpicker" required>
                          <option value="">Seleccione</option>

                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="municipio_residencia">Municipio de residencia (*)</label>
                      <div class="input-group">
                        <select id="municipio_residencia" name="municipio_residencia" class="form-control selectpicker" required disabled>
                          <option value="">Seleccione</option>

                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="parroquia_residencia">Parroquia de residencia (*)</label>
                      <div class="input-group">
                        <select id="parroquia_residencia" name="parroquia_residencia" class="form-control selectpicker" required disabled>
                          <option value="">Seleccione</option>

                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="direccion">Dirección de residencia (*)</label>
                      <div class="input-group">
                        <input type="text" name="direccion" id="direccion" class="form-control" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

              </div>
            </div>


            <!-- <div class="col-sm-6">
              <div class="card border-right-0 border-bottom-0 border-left-0  shadow mb-5 bg-white border-top-0 rounded">
                <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                  <h5 class="m-0 p-0 lead font-italic font-weight-bold text-white"><i class="fas fa-user-md "></i> Aspectos fisiológicos
                    <small class="text-dark">(Requerido)</small>
                  </h5>
                </div>

                <div class="card-body">
                  <div class="row">

                    <div class="form-group col-md-6">
                      <label for="peso">Peso (Kilos)</label>
                      <div class="input-group">

                        <div class="input-group">
                          <input type="text" class="form-control punto_peso solo_numeros" name="peso" id="peso" maxlength="5">

                        </div>

                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="talla">Talla (Metros)</label>
                      <div class="input-group">

                        <div class="input-group">
                          <input type="text" class="form-control talla punto_talla solo_numeros " name="talla" id="talla" maxlength="4">

                        </div>

                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">¿Todas las vacunas? (*)</label>
                      <div class="input-group">

                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="vacunasSi" name="vacunas" class="custom-control-input" required value="1">
                          <label class="custom-control-label" for="vacunasSi">Si</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>



                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="vacunasNo" name="vacunas" class="custom-control-input" required value="0">
                          <label class="custom-control-label" for="vacunasNo">No</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>


                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">¿Alergico? (*)</label>
                      <div class="input-group">

                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="alergicoSi" name="alergia" class="custom-control-input" required value="1">
                          <label class="custom-control-label" for="alergicoSi">Si</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="alergicoNo" name="alergia" class="custom-control-input" required value="0">
                          <label class="custom-control-label" for="alergicoNo">No</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>


                      </div>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="">¿Diversidad funcional? (*)</label>
                      <div class="input-group">

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input diversidad" id="motora" value="motora" name="diversidad[]">
                          <label class="custom-control-label" for="motora">Motora</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input diversidad" id="autismo" value="autismo" name="diversidad[]">
                          <label class="custom-control-label" for="autismo">Autismo</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input diversidad" id="asperger" value="asperger" name="diversidad[]">
                          <label class="custom-control-label" for="asperger">Asperger</label>
                        </div>

                      </div>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="">¿Enfermedad? (*)</label>
                      <div class="input-group">

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input enfermedad" id="repiratoria" value="repiratoria" name="enfermedad[]">
                          <label class="custom-control-label" for="repiratoria">Respiratoria</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input enfermedad" id="renal" value="renal" name="enfermedad[]">
                          <label class="custom-control-label" for="renal">Renal</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input enfermedad" id="visual" value="visual" name="enfermedad[]">
                          <label class="custom-control-label" for="visual">Visual</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input enfermedad" id="auditiva" value="auditiva" name="enfermedad[]">
                          <label class="custom-control-label" for="auditiva">Auditiva</label>
                        </div>

                      </div>
                    </div>

                  </div>
                </div>

              </div>
            </div> -->

            <div class="col-sm-12">
              <div class="card border-right-0 border-bottom-0 border-left-0  shadow mb-5 bg-white border-top-0 rounded">
                <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                  <h5 class="m-0 p-0 lead font-italic font-weight-bold text-white"><i class="fas fa-wallet "></i> Aspectos socioeconómicos
                    <small class="text-dark">(Requerido)</small>
                  </h5>
                </div>

                <div class="card-body">
                  <div class="row">

                    <div class="form-group col-md-12">
                      <label for="">¿Tipo de vivienda? (*)</label>
                      <div class="input-group">

                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="casa" name="vivienda" class="custom-control-input" required value="casa">
                          <label class="custom-control-label" for="casa">Casa</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="apartamento" name="vivienda" class="custom-control-input" required value="apartamento">
                          <label class="custom-control-label" for="apartamento">Apartamento</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="otro" name="vivienda" class="custom-control-input" required value="otro">
                          <label class="custom-control-label" for="otro">Otro</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="">Personas que mantienen el hogar (*)</label>
                      <div class="input-group">

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input sosten" id="papa" value="papa" name="sosten[]">
                          <label class="custom-control-label" for="papa">Papá</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input sosten" id="mama" value="mama" name="sosten[]">
                          <label class="custom-control-label" for="mama">Mamá</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input sosten" id="abuelos" value="abuelos" name="sosten[]">
                          <label class="custom-control-label" for="abuelos">Abuelos</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input sosten" id="otros" value="otros" name="sosten[]">
                          <label class="custom-control-label" for="otros">Otros</label>
                        </div>

                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="grupo_familiar">Nº personas que integran la familia (*)</label>
                      <div class="input-group">

                        <div class="input-group">
                          <input type="text" class="form-control solo_numeros " name="grupo_familiar" id="grupo_familiar" maxlength="2" placeholder="Ej: 4">

                        </div>

                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="ingreso_mensual">Ingreso Mensual Bs.F (*)</label>
                      <div class="input-group">

                        <div class="input-group">
                          <input type="text" class="form-control solo_numeros_decimales " name="ingreso_mensual" id="ingreso_mensual">

                        </div>

                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="">¿Posee canaima? (*)</label>
                      <div class="input-group">

                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="canaimaSi" name="canaima" class="custom-control-input" required value="si">
                          <label class="custom-control-label" for="canaimaSi">Si</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>



                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="canaimaNo" name="canaima" class="custom-control-input" required value="no">
                          <label class="custom-control-label" for="canaimaNo">No</label>
                          <div class="invalid-feedback">
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="condicion_canaima">Condición</label>
                      <div class="input-group">

                        <div class="input-group">
                          <input type="text" class="form-control" name="condicion_canaima" id="condicion_canaima" disabled>

                        </div>

                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

              </div>
            </div>

            <div class="container">
              <div class="row d-flex justify-content-end pr-3">
                <button class="btn btn-outline-danger btn-pill m-1 shadow-sm" type="button" onclick="cancelarform()"><i class="fas fa-times "></i> Cancelar</button>
                <button class="btn btn-outline-success btn-pill btn-lg m-1 shadow-sm" type="submit" id="btnGuardar"><i class="fas fa-check"></i> Registrar</button>
              </div>
            </div>

          </div> <!-- Fin row -->
        </form> <!-- Fin del formulario -->
          


        <!-- Modal para retirar estudiante -->
        <div class="modal fade" id="retirarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog rounded modal-lg" role="document">
            <div class="modal-content">
              
              <form class="needs-validation" novalidate name="formularioRetirar" id="formularioRetirar"> <!-- Formulario para retirar -->

                <div class="modal-header fondo-degradado rounded">
                  <h5 class="modal-title text-white" id="exampleModalLabel">Retirar Estudiante</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                  <div class="row"> 

                      <div class="form-group col-md-6">
                        <label for="cedula_representante">Cédula representante (*)</label>

                        <div class="input-group">

                          <input type="text" class="form-control" name="cedula_representante"  id="cedula_representante" readonly>
                          
                          <div class="invalid-feedback" >
                              Campo Obligatorio
                          </div>

                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="nombre_completo_representante">Nombre completo representante (*)</label>

                        <div class="input-group">

                          <input type="text" class="form-control" name="nombre_completo_representante"  id="nombre_completo_representante" readonly>
                          
                          <div class="invalid-feedback" >
                              Campo Obligatorio
                          </div>

                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="cedula_estudiante">Cédula estudiante (*)</label>

                        <div class="input-group">

                          <input type="text" class="form-control" name="cedula_estudiante"  id="cedula_estudiante" readonly>

                          <input type="hidden" name="idestudianteretiro" id="idestudianteretiro"> <!-- Input oculto que guardará el id del estudiante cuando sea necesario -->
                          
                          <input type="hidden" name="idpersona" id="idpersona"> <!-- Input oculto que guardará el id de la persona estudiante cuando sea necesario -->
                          
                          <input type="hidden" name="id_ultima_planificacion" id="id_ultima_planificacion"> <!-- Input oculto que guardará el id de la ultima planificación cuando sea necesario -->
                          
                          <div class="invalid-feedback" >
                              Campo Obligatorio
                          </div>

                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="nombre_completo_estudiante">Nombre completo estudiante (*)</label>

                        <div class="input-group">

                          <input type="text" class="form-control" name="nombre_completo_estudiante"  id="nombre_completo_estudiante" readonly>
                          
                          <div class="invalid-feedback" >
                              Campo Obligatorio
                          </div>

                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="ultimo_grado_cursado">Último grado cursado (*)</label>

                        <div class="input-group">

                          <input type="text" class="form-control" name="ultimo_grado_cursado"  id="ultimo_grado_cursado" readonly>
                          
                          <div class="invalid-feedback" >
                              Campo Obligatorio
                          </div>

                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="condicion">Condición (*)</label>

                        <div class="input-group">

                          <input type="text" class="form-control" name="condicion"  id="condicion" readonly>
                          
                          <div class="invalid-feedback" >
                              Campo Obligatorio
                          </div>

                        </div>
                      </div>

                      <div class="form-group col-md-12">
                        <label for="plantel_inscrito">Plantel a ser inscrito (*)</label>

                        <div class="input-group">

                          <input type="text" class="form-control" name="plantel_inscrito"  id="plantel_inscrito" required autocomplete="off">
                          
                          <div class="invalid-feedback" >
                              Campo Obligatorio
                          </div>

                        </div>
                      </div>

                      <div class="form-group col-md-12">
                        <label for="lugar">Lugar (*)</label>

                        <div class="input-group">

                          <input type="text" class="form-control" name="lugar"  id="lugar" required autocomplete="off">
                          
                          <div class="invalid-feedback" >
                              Campo Obligatorio
                          </div>

                        </div>
                      </div>
                       
                      <div class="form-group col-md-12">
                        <label class="col-md-6 col-form-label" for="textarea-input">Causa retiro</label>
                        <div class="col-md-12">
                            <textarea class="form-control" id="causa_retiro" name="causa_retiro" rows="2" placeholder="Causa" required></textarea>
                        </div>
                      </div> 

                      <div class="form-group col-md-12">
                        <label class="col-md-6 col-form-label" for="textarea-input">Observaciones</label>
                        <div class="col-md-12">
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2" placeholder="Observaciones "></textarea>
                        </div>
                      </div>  
                    

                  </div> <!-- Fin row -->     
                
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarformRetirar()">Cancelar</button>
                  <button type="submit" id="btnRetirar" class="btn btn-primary">Retirar</button>
                </div>


              </form> <!-- Fin del formulario -->
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</main>
<!-- Fin Contenido -->

<?php

} //Cierre del if que determina el acceso
else {
  ?>
<script>
  window.onload = function noacceso() {
    Swal.fire({
      type: 'warning',
      title: 'Restringido',
      text: 'Usted no tiene acceso a esta sección',
      showConfirmButton: false,
      allowOutsideClick: false,
      footer: '<a href="escritorio.php">Volver al escritorio</a>'
    })
  }
</script>
<?php
} // cierre del else

require_once 'modules/footer.php';
?>
<script src="scripts/estudiante.js"></script>

<?php
} //Cierre del else que muestra esta vista
ob_end_flush();
?>