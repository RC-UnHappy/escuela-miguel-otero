//Validar formulario bootstrap lado del cliente
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
  form.addEventListener('submit', function(event) {
    if (form.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add('was-validated');
  }, false);
});

//Muestra el año actual
function fecha_actual() {
	fecha = new Date();
	year = fecha.getFullYear();
	$('#fecha_actual').append(year);
}

//teclas permitidas
teclas_especiales = [8,9]; 
teclas_letras = "abcdefghijklmnñopqrstuvwxyzáéíóúüÁÉÍÓÚÜABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
teclas_numeros = "1234567890";
teclas_numeros_decimales = "1234567890,";

//Permite escribir sólo letras
$('.solo_letras').on('keypress', function (event) {
    codigo = event.keyCode;
	caracter = String.fromCharCode(codigo);
	return teclas_letras.indexOf(caracter) != -1 || false;
});

//Permite escribir sólo números
$('.solo_numeros').on('keypress', function (event) {
    codigo = event.keyCode;
	caracter = String.fromCharCode(codigo);
	return teclas_numeros.indexOf(caracter) != -1 || false;
});

//Permite escribir sólo números y decimales
$('.solo_numeros_decimales').on('keypress', function (event) {
    codigo = event.keyCode;
	caracter = String.fromCharCode(codigo);
	return teclas_numeros_decimales.indexOf(caracter) != -1 || false;
});

//Agrega el guión a los números telefónicos
$('.guion_telefonico').on('keypress', function (event) {
    numero = this.value;
    if (numero.length == 4) {
    	this.value = numero+'-';
    }
    else if (numero.length == 4 && event.keyCode == 8) {
    	this.value = numero.substr(0,4);
    }
});

//Agrega el punto en el campo de peso
$('.punto_peso').on('keypress', function (event) {
    numero = this.value;
    if (numero.length == 2) {
    	this.value = numero+'.';
    }
    else if (numero.length == 2 && event.keyCode == 8) {
    	this.value = numero.substr(0,2);
    }
});

//Agrega el punto en el campo de talla
$('.punto_talla').on('keypress', function (event) {
    numero = this.value;
    if (numero.length == 1) {
    	this.value = numero+'.';
    }
    else if (numero.length == 1 && event.keyCode == 8) {
    	this.value = numero.substr(0,1);
    }
});

//Agrega el punto en el campo de talla
$('.talla').on('keyup', function (event) {
    numero = this.value;
    if (numero.substr(0,1) == '0' || numero.substr(0,1) == '1') {
    	this.value = numero;
    }
    else{
    	this.value = numero.substr(0,0);
    }

});

//Cambia el color al ícono de género
$('.genero').on('change', function () {
	var genero = $('.genero')[1].value;
	// console.log($('.genero'));
	if (genero == 'M') {
		$('#icono_genero').removeClass('bg-danger');
		$('#icono_genero').addClass('bg-primary');
	}
	else if (genero == 'F'){
		$('#icono_genero').removeClass('bg-primary');
		$('#icono_genero').addClass('bg-danger');
	}
	else if (genero == ''){
		$('#icono_genero').removeClass('bg-primary');
		$('#icono_genero').removeClass('bg-danger');
	}
});

//Función para actualizar la información del usuario
function actualizarPerfil(id) {
	$(location).attr('href', 'usuario.php?actualizarPerfil&id='+id);
}


fecha_actual();
