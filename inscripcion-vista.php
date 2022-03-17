<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
    header('location: ../login.html');
} else {
    define('IMAGE_PATH', dirname((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 2) . '/../public/img/');
    require_once '../modules/header.php';

    if (isset($_SESSION['permisos']['inscripcion']) && in_array('ver', $_SESSION['permisos']['inscripcion'])) {

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
                            <div class="pl-3 col-md-12 d-flex justify-content-start">
                                <!-- Botón para mostrar modal inscripción inicial -->

                                <?php
                                if (
                                    isset($_SESSION['permisos']['inscripcion']) &&
                                    in_array('agregar', $_SESSION['permisos']['inscripcion'])
                                ) {
                                    echo
                                    '<h1 class="font-weight-normal h5 mr-3">Inscripción 
                    <button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#inscripcionModal" id="btnAgregar">
                        <i class="fa fa-plus-circle"></i> Inicial
                    </button>
                </h1>';
                                }
                                ?>


                                <?php
                                if ($_SESSION['rol'] == 'Docente') {
                                } else {
                                    echo
                                    '<!-- Botón para mostrar modal inscripción regular-->
                  <h1 class="font-weight-normal h5">
                      <button class="btn btn-outline-danger btn-pill shadow-sm" data-toggle="modal" data-target="#listadoInscripcionRegularModal" id="btnInscripcionRegular">
                          <i class="fa fa-plus-circle"></i> Regular
                      </button>
                  </h1>';
                                }
                                ?>


                            </div>
                        </div>

                        <div class="row" id="listadoregistros">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped" id="tblistado">
                                        <caption>Lista de planificaciones</caption>
                                        <thead class="fondo-degradado text-white">
                                            <tr>
                                                <th scope="col" style="width:100px">Opciones</th>
                                                <th scope="col" style="width:100px">Grado</th>
                                                <th scope="col" style="width:100px">Sección</th>
                                                <th scope="col">Docente</th>
                                                <th scope="col" style="width:500px">Cupo</th>
                                                <th scope="col">Período Escolar</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para inscripción incial-->
                        <div class="modal fade" id="inscripcionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog rounded modal-xl" role="document">
                                <div class="modal-content">

                                    <form class="needs-validation" novalidate name="formularioInscripcion" id="formularioregistros">
                                        <!-- Formulario de inscripción -->

                                        <div class="modal-header fondo-degradado rounded">
                                            <h5 class="modal-title text-white" id="exampleModalLabel">Inscripción Inicial</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="row">

                                                <!-- estudiante -->
                                                <div class="col-sm-12">
                                                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-3 bg-white rounded">
                                                        <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                                                            <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-user-graduate"></i> Datos del estudiante
                                                                <small class="text-dark">(Requerido)</small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row" id="comienzoFormulario">

                                                                <div class="form-group col-md-3">
                                                                    <label for="documento_estudiante">Documento del estudiante (*)</label>
                                                                    <div class="input-group ">
                                                                        <select name="documento_estudiante" id="documento_estudiante" class="form-control selectpicker" required="true">
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
                                                                    <label for="cedula_estudiante">Cédula del estudiante (*)</label>
                                                                    <div class="input-group">

                                                                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula_estudiante" id="cedula_estudiante" maxlength="8" minlength="7" required>

                                                                        <div class="invalid-feedback" id="mensajeCedula">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-3">
                                                                    <label for="p_nombre_estudiante">Primer Nombre (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_nombre_estudiante" id="p_nombre_estudiante" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-3">
                                                                    <label for="s_nombre_estudiante">Segundo Nombre</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_nombre_estudiante" id="s_nombre_estudiante">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-3">
                                                                    <label for="p_apellido_estudiante">Primer Apellido (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_apellido_estudiante" id="p_apellido_estudiante" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-3">
                                                                    <label for="s_apellido_estudiante">Segundo Apellido</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_apellido_estudiante" id="s_apellido_estudiante">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="f_nac_estudiante">Fecha Nacimiento (*)</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-calendar-alt"></i>
                                                                            </div>
                                                                        </div>
                                                                        <input type="date" name="f_nac_estudiante" id="f_nac_estudiante" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="genero_estudiante">Género (*)</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text" id="icono_genero">
                                                                                <i class="fas fa-venus-mars"></i>
                                                                            </div>
                                                                        </div>
                                                                        <select name="genero_estudiante" class="form-control selectpicker genero" id="genero_estudiante" required>
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
                                                                    <label for="pais_nacimiento_estudiante">País nacimiento (*)</label>
                                                                    <div class="input-group">
                                                                        <select id="pais_nacimiento_estudiante" name="pais_nacimiento_estudiante" class="form-control selectpicker" data-live-search="true" required>
                                                                            <option value="">Seleccione</option>

                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-3">
                                                                    <label for="estado_nacimiento_estudiante">Estado nacimiento (*)</label>
                                                                    <div class="input-group">
                                                                        <select id="estado_nacimiento_estudiante" name="estado_nacimiento_estudiante" class="form-control selectpicker" data-live-search="true" required disabled>
                                                                            <option value="">Seleccione</option>

                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-3">
                                                                    <label for="municipio_nacimiento_estudiante">Municipio nacimiento (*)</label>
                                                                    <div class="input-group">
                                                                        <select id="municipio_nacimiento_estudiante" name="municipio_nacimiento_estudiante" class="form-control selectpicker" data-live-search="true" required disabled>
                                                                            <option value="">Seleccione</option>

                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-3">
                                                                    <label for="parroquia_nacimiento_estudiante">Parroquia nacimiento (*)</label>
                                                                    <div class="input-group">
                                                                        <select id="parroquia_nacimiento_estudiante" name="parroquia_nacimiento_estudiante" class="form-control selectpicker" data-live-search="true" required disabled>
                                                                            <option value="">Seleccione</option>

                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="plantel_procedencia_estudiante">Plantel de procedencia</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="plantel_procedencia_estudiante" id="plantel_procedencia_estudiante">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- madre -->
                                                <div class="col-sm-6">
                                                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-1 bg-white rounded">
                                                        <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                                                            <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-female"></i> Datos de la madre
                                                                <small class="text-dark">(Requerido)</small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row">

                                                                <div class="form-group col-md-6">
                                                                    <label for="documento_madre">Tipo de documento (*)</label>
                                                                    <div class="input-group ">
                                                                        <select name="documento_madre" id="documento_madre" class="form-control selectpicker" required="true">
                                                                            <option value="">Seleccione</option>
                                                                            <option value="venezolano">Venezolano</option>
                                                                            <option value="extranjero">Extranjero</option>
                                                                            <option value="pasaporte">Pasaporte</option>
                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="cedula_madre">Cédula (*)</label>
                                                                    <div class="input-group">

                                                                        <input type="hidden" name="idmadre" id="idmadre"> <!-- Input oculto que guardará el id de la madre cuando sea necesario -->

                                                                        <input type="hidden" name="idpersonamadre" id="idpersonamadre"> <!-- Input oculto que guardará el id de la persona cuando sea necesario -->

                                                                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula_madre" id="cedula_madre" maxlength="8" minlength="7" required>

                                                                        <div class="invalid-feedback" id="mensajeCedula">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="p_nombre_madre">Primer Nombre (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_nombre_madre" id="p_nombre_madre" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="s_nombre_madre">Segundo Nombre</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_nombre_madre" id="s_nombre_madre">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="p_apellido_madre">Primer Apellido (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_apellido_madre" id="p_apellido_madre" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="s_apellido_madre">Segundo Apellido</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_apellido_madre" id="s_apellido_madre">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="oficio_madre">Profesión (*)</label>
                                                                    <div class="input-group">

                                                                        <input type="text" name="oficio_madre" id="oficio_madre" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="celular_madre">Teléfono Celular</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-mobile-alt"></i>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" name="celular_madre" id="celular_madre" class="form-control solo_numeros guion_telefonico" maxlength="12">
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="direccion_residencia_madre">Dirección de habitación (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="direccion_residencia_madre" id="direccion_residencia_madre" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="direccion_trabajo_madre">Dirección de trabajo (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="direccion_trabajo_madre" id="direccion_trabajo_madre" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- padre -->
                                                <div class="col-sm-6">
                                                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-3 bg-white rounded">
                                                        <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                                                            <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-male"></i> Datos del padre
                                                                <small class="text-dark">(Requerido)</small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row">

                                                                <div class="form-group col-md-6">
                                                                    <label for="documento_padre">Tipo de documento (*)</label>
                                                                    <div class="input-group ">
                                                                        <select name="documento_padre" id="documento_padre" class="form-control selectpicker"="true">
                                                                            <option value="">Seleccione</option>
                                                                            <option value="venezolano">Venezolano</option>
                                                                            <option value="extranjero">Extranjero</option>
                                                                            <option value="pasaporte">Pasaporte</option>
                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="cedula_padre">Cédula (*)</label>
                                                                    <div class="input-group">

                                                                        <input type="hidden" name="idpadre" id="idpadre"> <!-- Input oculto que guardará el id del padre cuando sea necesario -->

                                                                        <input type="hidden" name="idpersonapadre" id="idpersonapadre"> <!-- Input oculto que guardará el id de la persona cuando sea necesario -->

                                                                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula_padre" id="cedula_padre" maxlength="8" minlength="7">

                                                                        <div class="invalid-feedback" id="mensajeCedula">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="p_nombre_padre">Primer Nombre (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_nombre_padre" id="p_nombre_padre">
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="s_nombre_padre">Segundo Nombre</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_nombre_padre" id="s_nombre_padre">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="p_apellido_padre">Primer Apellido (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_apellido_padre" id="p_apellido_padre">
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="s_apellido_padre">Segundo Apellido</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_apellido_padre" id="s_apellido_padre">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="oficio_padre">Profesión (*)</label>
                                                                    <div class="input-group">

                                                                        <input type="text" name="oficio_padre" id="oficio_padre" class="form-control">
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="celular_padre">Teléfono Celular</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-mobile-alt"></i>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" name="celular_padre" id="celular_padre" class="form-control solo_numeros guion_telefonico" maxlength="12">
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="direccion_residencia_padre">Dirección de habitación (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="direccion_residencia_padre" id="direccion_residencia_padre" class="form-control">
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="direccion_trabajo_padre">Dirección de trabajo (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="direccion_trabajo_padre" id="direccion_trabajo_padre" class="form-control">
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- representante -->
                                                <div class="col-sm-6">
                                                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-3 bg-white rounded">
                                                        <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                                                            <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-user-tie"></i> Datos del representante
                                                                <small class="text-dark">(Requerido)</small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row">

                                                                <div class="form-group col-md-6">
                                                                    <label for="documento_representante">Tipo de documento (*)</label>
                                                                    <div class="input-group ">
                                                                        <select name="documento_representante" id="documento_representante" class="form-control selectpicker" required="true">
                                                                            <option value="">Seleccione</option>
                                                                            <option value="venezolano">Venezolano</option>
                                                                            <option value="extranjero">Extranjero</option>
                                                                            <option value="pasaporte">Pasaporte</option>
                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="cedula_representante">Cédula (*)</label>
                                                                    <div class="input-group">

                                                                        <input type="hidden" name="idrepresentante" id="idrepresentante"> <!-- Input oculto que guardará el id del representante cuando sea necesario -->

                                                                        <input type="hidden" name="idpersonarepresentante" id="idpersonarepresentante"> <!-- Input oculto que guardará el id de la persona cuando sea necesario -->

                                                                        <input type="hidden" name="tiporepresentante" id="tiporepresentante">

                                                                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula_representante" id="cedula_representante" maxlength="8" minlength="7" required>

                                                                        <div class="invalid-feedback" id="mensajeCedula">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="p_nombre_representante">Primer Nombre (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_nombre_representante" id="p_nombre_representante" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="s_nombre_representante">Segundo Nombre</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_nombre_representante" id="s_nombre_representante">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="p_apellido_representante">Primer Apellido (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_apellido_representante" id="p_apellido_representante" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="s_apellido_representante">Segundo Apellido</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_apellido_representante" id="s_apellido_representante">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="oficio_representante">Profesión (*)</label>
                                                                    <div class="input-group">

                                                                        <input type="text" name="oficio_representante" id="oficio_representante" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="celular_representante">Teléfono Celular</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-mobile-alt"></i>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" name="celular_representante" id="celular_representante" class="form-control solo_numeros guion_telefonico" maxlength="12">
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="genero_representante">Género (*)</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-venus-mars"></i>
                                                                            </div>
                                                                        </div>
                                                                        <select name="genero_representante" class="form-control selectpicker" id="genero_representante" required>
                                                                            <option value="">Seleccione</option>
                                                                            <option value="M">Masculino</option>
                                                                            <option value="F">Femenino</option>
                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="parentesco_representante">Parentesco (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="parentesco_representante" id="parentesco_representante" class="form-control solo_letras text-uppercase" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="direccion_residencia_representante">Dirección de habitación (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="direccion_residencia_representante" id="direccion_residencia_representante" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="direccion_trabajo_representante">Dirección de trabajo (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="direccion_trabajo_representante" id="direccion_trabajo_representante" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- documentos consignados -->
                                                <div class="col-sm-6">
                                                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-3 bg-white rounded">
                                                        <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                                                            <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-file"></i> Documentos consignados
                                                                <small class="text-dark">(Requerido)</small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row">

                                                                <div class="form-group col-md-12 mb-4">
                                                                    <label for="">Documentos padres y representante</label>
                                                                    <div class="input-group">

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="fotocopia_cedula_madre" value="fotocopia_cedula_madre" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="fotocopia_cedula_madre">Fotocopia cédula madre</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="fotocopia_cedula_padre" value="fotocopia_cedula_padre" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="fotocopia_cedula_padre">Fotocopia cédula padre</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="fotocopia_cedula_representante" value="fotocopia_cedula_representante" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="fotocopia_cedula_representante">Fotocopia cédula representante</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="fotos_representante" value="fotos_representante" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="fotos_representante">Fotos del representante</label>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="">Documentos del estudiante</label>
                                                                    <div class="input-group">

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="fotocopia_partida_nacimiento" value="fotocopia_partida_nacimiento" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="fotocopia_partida_nacimiento">Fotocopia partida nacimiento</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="fotocopia_cedula_estudiante" value="fotocopia_cedula_estudiante" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="fotocopia_cedula_estudiante">Fotocopia cédula estudiante</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="fotocopia_constancia_vacunas" value="fotocopia_constancia_vacunas" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="fotocopia_constancia_vacunas">Fotocopia constancia vacunas</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="fotos_estudiante" value="fotos_estudiante" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="fotos_estudiante">Fotos del estudiante</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="boleta_promocion" value="boleta_promocion" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="boleta_promocion">Boleta de promoción</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="constancia_buena_conducta" value="constancia_buena_conducta" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="constancia_buena_conducta">Constancia buena conducta</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="informe_descriptivo" value="informe_descriptivo" name="documentos_consignados[]">
                                                                            <label class="custom-control-label" for="informe_descriptivo">Informe descriptivo final</label>
                                                                        </div>

                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- inscripción -->
                                                <div class="col-sm-12">
                                                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-3 bg-white rounded">
                                                        <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                                                            <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-money-check"></i> Inscripción
                                                                <small class="text-dark">(Requerido)</small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row">

                                                                <div class="form-group col-md-3">
                                                                    <label for="planificacion">Planificación (*)</label>
                                                                    <div class="input-group ">
                                                                        <select name="idplanificacion" id="planificacion" class="form-control selectpicker " required="true">
                                                                            <option value="">Seleccione</option>

                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- <div class="form-group col-md-3">
                                          <label for="">¿Repite? (*)</label>
                                          <div class="input-group">

                                              <div class="custom-control custom-radio custom-control-inline">
                                                  <input type="radio" id="repiteSi" name="repite" class="custom-control-input" required value="si">
                                                  <label class="custom-control-label" for="repiteSi">Si</label>
                                                  <div class="invalid-feedback">
                                                  </div>
                                              </div>

                                              <div class="custom-control custom-radio custom-control-inline">
                                                  <input type="radio" id="repiteNo" name="repite" class="custom-control-input" required value="no">
                                                  <label class="custom-control-label" for="repiteNo">No</label>
                                                  <div class="invalid-feedback">
                                                  </div>
                                              </div>

                                          </div>
                                      </div> -->

                                                                <div class="form-group col-md-9">
                                                                    <label class="col-md-6 col-form-label" for="textarea-input">Observaciones</label>
                                                                    <div class="col-md-12">
                                                                        <textarea class="form-control" id="observaciones" name="observaciones" rows="5" placeholder="Juicio del Docente Guía / Observaciones "></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div> <!-- Fin row -->

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarform()">Cancelar</button>
                                                <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
                                            </div>

                                        </div>
                                    </form> <!-- Fin del formulario -->
                                </div>
                            </div>
                        </div>

                        <!-- Modal para el listado de inscripción regular -->
                        <div class="modal fade" id="listadoInscripcionRegularModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog rounded modal-xl" role="document">
                                <div class="modal-content">

                                    <div class="modal-header fondo-degradado rounded">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">Estudiantes regulares</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <!-- lisata de estudiantes esperanda a ser inscritos o retirados -->
                                        <div class="row" id="listadoinscripcionregular">
                                            <div class="col-sm-12">
                                                <div class="table-responsive ">
                                                    <table class="table table-borderless table-striped w-100" id="tblistadoinscripcionregular">
                                                        <caption>Lista de inscripción regular</caption>
                                                        <thead class="fondo-degradado text-white">
                                                            <tr>
                                                                <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                                <th scope="col">Cédula</th>
                                                                <th scope="col">Nombre</th>
                                                                <th scope="col">Apellido</th>
                                                                <th scope="col">Último grado cursado</th>
                                                                <th scope="col">Estatus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> <!-- Fin row -->


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarform()">Cancelar</button>
                                            <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para inscripción regular-->
                        <div class="modal fade" id="inscripcionRegularModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog rounded modal-lg" role="document">
                                <div class="modal-content">

                                    <form class="needs-validation" novalidate name="formularioInscripcionRegular" id="formularioInscripcionRegular">
                                        <!-- Formulario de inscripción regular-->

                                        <div class="modal-header fondo-degradado rounded">
                                            <h5 class="modal-title text-white" id="exampleModalLabel">Inscripción regular</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="row">
                                                <!-- representante -->
                                                <div class="col-sm-12">
                                                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-3 bg-white rounded">
                                                        <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                                                            <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-user-tie"></i> Datos del representante
                                                                <small class="text-dark">(Requerido)</small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row">

                                                                <div class="form-group col-md-6">
                                                                    <label for="documento_representante_regular">Tipo de documento (*)</label>
                                                                    <div class="input-group ">
                                                                        <select name="documento_representante_regular" id="documento_representante_regular" class="form-control selectpicker" required="true">
                                                                            <option value="">Seleccione</option>
                                                                            <option value="V-">Venezolano</option>
                                                                            <option value="E-">Extranjero</option>
                                                                            <option value="P-">Pasaporte</option>
                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="cedula_representante_regular">Cédula (*)</label>
                                                                    <div class="input-group">

                                                                        <input type="hidden" name="idrepresentante_regular" id="idrepresentante_regular"> <!-- Input oculto que guardará el id del representante cuando sea necesario -->

                                                                        <input type="hidden" name="idpersonarepresentante_regular" id="idpersonarepresentante_regular"> <!-- Input oculto que guardará el id de al persona cuando sea necesario -->

                                                                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula_representante_regular" id="cedula_representante_regular" maxlength="8" minlength="7" required>

                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="p_nombre_representante_regular">Primer Nombre (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_nombre_representante_regular" id="p_nombre_representante_regular" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="s_nombre_representante_regular">Segundo Nombre</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_nombre_representante_regular" id="s_nombre_representante_regular">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="p_apellido_representante_regular">Primer Apellido (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="p_apellido_representante_regular" id="p_apellido_representante_regular" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="s_apellido_representante_regular">Segundo Apellido</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control solo_letras" name="s_apellido_representante_regular" id="s_apellido_representante_regular">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="oficio_representante_regular">Profesión (*)</label>
                                                                    <div class="input-group">

                                                                        <input type="text" name="oficio_representante_regular" id="oficio_representante_regular" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="celular_representante_regular">Teléfono Celular</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-mobile-alt"></i>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" name="celular_representante_regular" id="celular_representante_regular" class="form-control solo_numeros guion_telefonico" maxlength="12">
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="genero_representante_regular">Género (*)</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-venus-mars"></i>
                                                                            </div>
                                                                        </div>
                                                                        <select name="genero_representante_regular" class="form-control selectpicker genero" id="genero_representante_regular" required>
                                                                            <option value="">Seleccione</option>
                                                                            <option value="M">Masculino</option>
                                                                            <option value="F">Femenino</option>
                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="parentesco_representante_regular">Parentesco (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="parentesco_representante_regular" id="parentesco_representante_regular" class="form-control solo_letras text-uppercase" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="direccion_residencia_representante_regular">Dirección de habitación (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="direccion_residencia_representante_regular" id="direccion_residencia_representante_regular" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="direccion_trabajo_representante_regular">Dirección de trabajo (*)</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="direccion_trabajo_representante_regular" id="direccion_trabajo_representante_regular" class="form-control" required>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- inscripción regular-->
                                                <div class="col-sm-12">
                                                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-3 bg-white rounded">
                                                        <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                                                            <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-money-check"></i> Inscripción
                                                                <small class="text-dark">(Requerido)</small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row">

                                                                <input type="hidden" name="idestudiante_regular" id="idestudiante_regular"> <!-- Input oculto que guardará el id del estudiante regular cuando sea necesario -->

                                                                <div class="form-group col-md-3">
                                                                    <label for="periodo_escolar_regular">Período escolar (*)</label>
                                                                    <div class="input-group ">
                                                                        <select name="idperiodo_escolar_regular" id="periodo_escolar_regular" class="form-control selectpicker" required="true">

                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-3">
                                                                    <label for="planificacion_regular">Planificación (*)</label>
                                                                    <div class="input-group ">
                                                                        <select name="idplanificacion_regular" id="planificacion_regular" class="form-control selectpicker " required="true">
                                                                            <!-- <option value="">Seleccione</option> -->

                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo Obligatorio
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label class="col-md-6 col-form-label" for="textarea-input">Observaciones</label>
                                                                    <div class="col-md-12">
                                                                        <textarea class="form-control" id="observaciones_regular" name="observaciones_regular" rows="5" placeholder="Juicio del Docente Guía / Observaciones " required></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- Fin row -->

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarform()">Cancelar</button>
                                                <button type="submit" id="btnGuardarInscripcionRegular" class="btn btn-primary">Guardar</button>
                                            </div>

                                        </div>
                                    </form> <!-- Fin del formulario -->
                                </div>
                            </div>
                        </div>

                        <!-- Modal para ver los estudiantes de una sección -->
                        <div class="modal fade" id="estudiantesSeccionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog rounded modal-xl" role="document">
                                <div class="modal-content">

                                    <div class="modal-header fondo-degradado rounded">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">Lista de estudiantes</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless table-striped" id="tblistadoEstudiantes">
                                                        <caption>Lista de estudiantes</caption>
                                                        <thead class="fondo-degradado text-white">
                                                            <tr>
                                                                <th scope="col">Opciones</th>
                                                                <th scope="col">Cédula</th>
                                                                <th scope="col">Primer nombre</th>
                                                                <th scope="col">Segundo nombre</th>
                                                                <th scope="col">Primer apellido</th>
                                                                <th scope="col">Segundo apellido</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Modal para editar inscripción-->
                        <div class="modal fade" id="editarInscripcionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog rounded" role="document">
                                <div class="modal-content">

                                    <form class="needs-validation" novalidate name="formularioEditarInscripcion" id="formularioEditarInscripciond">

                                        <div class="modal-header fondo-degradado rounded">
                                            <h5 class="modal-title text-white" id="exampleModalLabel">Editar Inscripción</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col-sm-12">
                                                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-3 bg-white rounded">
                                                        <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                                                            <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-file"></i> Documentos consignados
                                                                <small class="text-dark">(Requerido)</small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row">
                                                                <input type="hidden" name="idEditarInscrpicion" id="idEditarInscrpicion">
                                                                <div class="form-group col-md-12 mb-4">
                                                                    <label for="">Documentos padres y representante</label>
                                                                    <div class="input-group">

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_fotocopia_cedula_madre" value="editar_fotocopia_cedula_madre" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_fotocopia_cedula_madre">Fotocopia cédula madre</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_fotocopia_cedula_padre" value="editar_fotocopia_cedula_padre" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_fotocopia_cedula_padre">Fotocopia cédula padre</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_fotocopia_cedula_representante" value="editar_fotocopia_cedula_representante" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_fotocopia_cedula_representante">Fotocopia cédula representante</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_fotos_representante" value="editar_fotos_representante" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_fotos_representante">Fotos del representante</label>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="">Documentos del estudiante</label>
                                                                    <div class="input-group">

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_fotocopia_partida_nacimiento" value="editar_fotocopia_partida_nacimiento" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_fotocopia_partida_nacimiento">Fotocopia partida nacimiento</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_fotocopia_cedula_estudiante" value="editar_fotocopia_cedula_estudiante" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_fotocopia_cedula_estudiante">Fotocopia cédula estudiante</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_fotocopia_constancia_vacunas" value="editar_fotocopia_constancia_vacunas" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_fotocopia_constancia_vacunas">Fotocopia constancia vacunas</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_fotos_estudiante" value="editar_fotos_estudiante" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_fotos_estudiante">Fotos del estudiante</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_boleta_promocion" value="editar_boleta_promocion" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_boleta_promocion">Boleta de promoción</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_constancia_buena_conducta" value="editar_constancia_buena_conducta" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_constancia_buena_conducta">Constancia buena conducta</label>
                                                                        </div>

                                                                        <div class="custom-control custom-checkbox custom-control-inline col-md-6">
                                                                            <input type="checkbox" class="custom-control-input" id="editar_informe_descriptivo" value="editar_informe_descriptivo" name="editar_documentos_consignados[]">
                                                                            <label class="custom-control-label" for="editar_informe_descriptivo">Informe descriptivo final</label>
                                                                        </div>

                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div> <!-- Fin row -->

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarform()">Cancelar</button>
                                                <button type="submit" id="btnEditarInscripcion" class="btn btn-primary">Guardar</button>
                                            </div>

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
    } //cierre del if de permisos
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
                    footer: '<a href="../escritorio.php">Volver al escritorio</a>'
                })
            }
        </script>

    <?php
    } //cierre del else
    require_once '../modules/footer.php';
    ?>

    <script src="../scripts/inscripcion/inscripcion.js"></script>

<?php
} //Cierre del else que muestra esta vista
ob_end_flush();
?>