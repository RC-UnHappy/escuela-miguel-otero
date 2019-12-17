<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['usuario'])) {
  header('location: login.html');
}
else {
require_once 'modules/header.php';
if ($_SESSION['usuario'] == 1) {
?>

<!-- Contenido -->
      <main class="main">
        <div class="animated fadeIn">
          <div class="jumbotron jumbotron-fluid mb-0 fondo-degradado" >
          </div>
          <div class="container panel-principal col-sm-12">
            <div class="card border-light mb-3 shadow p-3 mb-5 bg-white rounded ">

              <div class="card-header pt-0 pb-1 bg-white mb-3"> <!-- Botonera del panel -->
              
                <h1 class="font-weight-normal h5">Representante
                  <button class="btn btn-outline-primary btn-pill shadow-sm" onclick="mostrarform(true)" id="btnagregar">
                    <i class="fa fa-plus-circle"></i> Agregar
                  </button>
                </h1>
              </div>
              
              <div class="row" id="listadoregistros">
                <div class="col-sm-12">
                  <div class="table-responsive">
                    <table class="table table-borderless table-striped" id="tblistado">
                      <caption>Lista de representantes</caption>
                      <thead class="fondo-degradado text-white">
                        <tr>
                          <th scope="col" style="width: 100px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                          <th scope="col">Cédula</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Apellido</th>
                          <th scope="col">Correo</th>
                          <th scope="col">Móvil</th>
                          <th scope="col">Fijo</th>
                          <th scope="col">Oficio</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                </div>  
              </div>

              <form class="needs-validation" novalidate name="representante" id="formularioregistros"> <!-- Formulario de representante -->
                <div class="row"> 
                
                  <div class="col-sm-6">
                    <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-5 bg-white rounded">
                      <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                        <h5 class="m-0 p-0  font-italic font-weight-bold text-white" ><i class="fas fa-user-edit"></i>  Personales
                          <small class="text-dark">(Requerido)</small>
                        </h5>
                      </div>
                      <div class="card-body">
                        
                        <div class="row">

                          <div class="form-group col-md-6">
                            <label for="documento">Tipo de documento (*)</label>
                              <div class="input-group ">
                                <select name="documento" id="documento" class="form-control selectpicker" required="true">
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
                            <label for="cedula">Cédula (*)</label>
                            <div class="input-group">

                              <input type="hidden" name="idrepresentante" id="idrepresentante"> <!-- Input oculto que guardará el id del representante cuando sea necesario -->

                              <input type="hidden" name="idpersona" id="idpersona"> <!-- Input oculto que guardará el id de al persona cuando sea necesario -->

                              <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula"  id="cedula"  maxlength="8" minlength="7" required>
                              
                              <div class="invalid-feedback" id="mensajeCedula">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="p_nombre">Primer Nombre (*)</label>
                            <div class="input-group">
                              <input type="text" class="form-control solo_letras" name="p_nombre" id="p_nombre" required >
                              <div class="invalid-feedback">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="s_nombre">Segundo Nombre</label>
                            <div class="input-group">
                              <input type="text" class="form-control solo_letras" name="s_nombre" id="s_nombre">
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="p_apellido">Primer Apellido (*)</label>
                            <div class="input-group">
                              <input type="text" class="form-control solo_letras" name="p_apellido" id="p_apellido" required>
                              <div class="invalid-feedback">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="s_apellido">Segundo Apellido</label>
                            <div class="input-group">
                              <input type="text" class="form-control solo_letras" name="s_apellido" id="s_apellido">
                            </div>
                          </div>

                          <div class="form-group col-md-6">
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

                          <div class="form-group col-md-6">
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

                          <div class="form-group col-md-6">
                            <label for="instruccion">Nivel de Instrucción (*)</label>
                            <div class="input-group">
                              
                              <select name="instruccion" id="instruccion" class="form-control selectpicker" required>
                                <option value="">Seleccione</option>
                                <option value="Analfabeta">Analfabeta</option>
                                <option value="Sin estudios">Sin estudios</option>
                                <option value="Educaciónn básica">Educación básica</option>
                                <option value="Educación media">Educación media</option>
                                <option value="Educación superior">Educación superior</option>
                              </select>
                              <div class="invalid-feedback">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="oficio">Oficio (*)</label>
                            <div class="input-group">
                              
                              <input type="text" name="oficio" id="oficio" class="form-control" required>
                              <div class="invalid-feedback">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-12">
                            <label for="email">Correo electrónico (*)</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="far fa-envelope"></i>
                                </div>
                              </div>
                              <input type="email" name="email" id="email" class="form-control" required>
                              <div class="invalid-feedback">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="celular">Teléfono Celular</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fas fa-mobile-alt"></i>
                                </div>
                              </div>
                              <input type="text" name="celular" id="celular" class="form-control solo_numeros guion_telefonico"  maxlength="12">
                              <div class="invalid-feedback">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="fijo">Teléfono Fijo</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fas fa-phone-alt"></i>
                                </div>
                              </div>
                              <input type="text" name="fijo" id="fijo" class="form-control solo_numeros guion_telefonico" maxlength="12">
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="card border-right-0 border-bottom-0 border-left-0  shadow mb-5 bg-white border-top-0 rounded">
                      <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                        <h5 class="m-0 p-0 lead font-italic font-weight-bold text-white" ><i class="fas fa-home "></i> Residenciales
                          <small class="text-dark">(Requerido)</small>
                        </h5>
                      </div>

                      <div class="card-body">
                        <div class="row">
                          
                          <div class="form-group col-md-6">
                            <label for="estado">Estado (*)</label>
                            <div class="input-group">
                              <select id="estado" name="estado" class="form-control selectpicker" required >
                                <option value="">Seleccione</option>
                                
                              </select>
                              <div class="invalid-feedback">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="municipio">Municipio (*)</label>
                            <div class="input-group">
                              <select id="municipio" name="municipio" class="form-control selectpicker" required disabled>
                                <option value="">Seleccione</option>
                                
                              </select>
                              <div class="invalid-feedback">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="parroquia">Parroquia (*)</label>
                            <div class="input-group">
                              <select id="parroquia" name="parroquia" class="form-control selectpicker" required disabled>
                                <option value="">Seleccione</option>
                                
                              </select>
                              <div class="invalid-feedback">
                                  Campo Obligatorio
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-12">
                            <label for="direccion">Dirección (*)</label>
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

                  
                  
                  <div class="container">
                    <div class="row d-flex justify-content-end pr-3">
                      <button class="btn btn-outline-danger btn-pill m-1 shadow-sm" type="button" onclick="cancelarform()"><i class="fas fa-times "></i> Cancelar</button>
                      <button class="btn btn-outline-success btn-pill btn-lg m-1 shadow-sm" type="submit" id="btnGuardar"><i class="fas fa-check"></i> Registrar</button>
                    </div>
                  </div>

                </div> <!-- Fin row -->     
              </form> <!-- Fin del formulario -->
              
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
          }
        )
      }
  </script>
<?php
}

require_once 'modules/footer.php';
?>
<script src="scripts/representante.js"></script>

<?php 
} //Cierre del else que muestra esta vista
ob_end_flush();
?>