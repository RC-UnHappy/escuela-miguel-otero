<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['usuario'])) {
    header('location: ../login.html');
} else {
    require_once '../modules/header.php';
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

                        <!-- Botón para mostrar modal inscripción -->
                        <h1 class="font-weight-normal h5">Inscripción Inicial
                            <button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#inscripcionModal" id="btnAgregar">
                                <i class="fa fa-plus-circle"></i> Inscribir
                            </button>
                        </h1>

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

                    <!-- Modal para inscribir -->
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

                                            <!-- guarda el id de la planificación cuando es necesario -->
                                            <input type="hidden" value="" id="idinscripcion" name="idinscripcion">

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

                                            <div class="form-group col-md-3">
                                                <label for="estudiante">Estudiante (*)</label>
                                                <div class="input-group ">
                                                    <select name="idestudiante" id="estudiante" class="form-control selectpicker" required="true" data-live-search="true">
                                                        <option value="">Seleccione</option>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Campo Obligatorio
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="representante">Representante (*)</label>
                                                <div class="input-group ">
                                                    <select name="idrepresentante" id="representante" class="form-control selectpicker " required="true" data-live-search="true">
                                                        <option value="">Seleccione</option>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Campo Obligatorio
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="estatus">Estatus (*)</label>
                                                <div class="input-group ">
                                                    <select name="estatus" id="estatus" class="form-control selectpicker" required="true">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Campo Obligatorio
                                                    </div>
                                                </div>
                                            </div>

                                        </div> <!-- Fin row -->

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarform()">Cancelar</button>
                                        <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
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

        require_once '../modules/footer.php';
        ?>
    <script src="../scripts/inscripcion/inicial.js"></script>

<?php
} //Cierre del else que muestra esta vista
ob_end_flush();
?>