
function fraseAleatoria() {

	var arreglo = new Array();

	arreglo[0] = {'autor':'Paulo Coelho', 'frase':'Un niño puede enseñar tres cosas a un adulto: a ponerse contento sin motivo, a estar siempre ocupado con algo y a saber exigir con todas sus fuerzas aquello que desea.'};
	
	arreglo[1] = {'autor':'Albert Einstein', 'frase':'Lo único que interfiere con mi aprendizaje es mi educación.'};

	arreglo[2] = {'autor':'Albert Einstein', 'frase':'Cualquier hombre que lee mucho y usa poco su propio cerebro, cae en hábitos perezosos de pensamiento.'};

	arreglo[3] = {'autor':'Albert Einstein', 'frase':'La sabiduría no es producto de la escolarización, sino de un intento a lo largo de la vida de adquirirlo.'};

	arreglo[4] = {'autor':'Albert Einstein', 'frase':'El arte supremo del maestro es despertar el placer de la expresión creativa y el conocimiento.'};

	arreglo[5] = {'autor':'Jorge Luis Borgues', 'frase':'La Universidad debiera insistirnos en lo antiguo y en lo ajeno. Si insiste en lo propio y lo contemporáneo, la Universidad es inútil, porque está ampliando una función que ya cumple la prensa.'};

	arreglo[6] = {'autor':'Aristóteles', 'frase':'Aquellos que educan bien a los niños merecen recibir más honores que sus propios padres, porque aquellos sólo les dieron vida, éstos el arte de vivir bien.'};

	arreglo[7] = {'autor':'Aristóteles', 'frase':'El educado difiere del no educado tanto como el que vive difiere del muerto.'};

	arreglo[8] = {'autor':'Aristóteles', 'frase':'Educar la mente sin educar el corazón no es educación en absoluto.'};

	arreglo[9] = {'autor':'Aristóteles', 'frase':'La educación es un ornamento en la prosperidad y un refugio en la adversidad.'};

	arreglo[10] = {'autor':'Aristóteles', 'frase':'La educación es un ornamento en la prosperidad y un refugio en la adversidad.'};

	arreglo[11] = {'autor':'Aristóteles', 'frase':'Es la marca de una mente educada ser capaz de entretener un pensamiento sin aceptarlo.'};

	arreglo[12] = {'autor':'Theodore Roosevelt', 'frase':'Un hombre que nunca ha ido a la escuela podría robar un vagón de carga, pero si tuviese una educación universitaria, podría robar el tren entero.'};

	arreglo[13] = {'autor':'Oscar Wilde', 'frase':'La educación es algo admirable, pero esta bien recordar de vez en cuando que nada que merezca la pena saber puede ser enseñado.'};

	arreglo[14] = {'autor':'Oscar Wilde', 'frase':'El mejor medio para hacer buenos a los niños es hacerlos felices.'};

	arreglo[15] = {'autor':'Antonio Machado', 'frase':'En cuestiones de cultura y de saber, sólo se pierde lo que se guarda; sólo se gana lo que se da.'};

	arreglo[16] = {'autor':'Nelson Mandela', 'frase':'La educación es el arma más poderosa que puedes usar para cambiar el mundo.'};

	arreglo[17] = {'autor':'Malcolm X', 'frase':'La educación es nuestro pasaporte para el futuro, porque el mañana pertenece a la gente que se prepara para el hoy.'};

	arreglo[18] = {'autor':'Abraham Lincoln', 'frase':'La filosofía del aula en una generación será la filosofía del gobierno en la siguiente.'};

	arreglo[19] = {'autor':'Abraham Lincoln', 'frase':'Las cosas que quiero saber están en los libros; mi mejor amigo es el hombre que me de un libro que no haya leído.'};

	arreglo[20] = {'autor':'Leonardo Da Vinci', 'frase':'El aprendizaje nunca cansa a la mente.'};

	arreglo[21] = {'autor':'Leonardo Da Vinci', 'frase':'El estudio sin deseo estropea la memoria y no retiene nada de lo que toma.'};

	arreglo[22] = {'autor':'Víctor Hugo', 'frase':'El que abre la puerta de una escuela, cierra una prisión.'};

	arreglo[23] = {'autor':'John F. Kennedy', 'frase':'Un niño con falta de educación es un niño perdido.'};

	arreglo[24] = {'autor':'John F. Kennedy', 'frase':'La meta de la educación es el avance en el conocimiento y la diseminación de la verdad.'};

	arreglo[25] = {'autor':'John F. Kennedy', 'frase':'La libertad sin educación es siempre un peligro; la educación sin libertad resulta vana.'};

	arreglo[26] = {'autor':'Confucio', 'frase':'La educación genera confianza. La confianza genera esperanza. La esperanza genera paz.'};

	arreglo[27] = {'autor':'Galileo Galilei', 'frase':'Si comenzase de nuevo mis estudios, seguiría el consejo de Platón y comenzaría con matemáticas.'};

	arreglo[28] = {'autor':'Walt Disney', 'frase':'Prefiero entretener y esperar que la gente aprenda algo que educar a la gente y esperar que la gente se entretenga.'};

	arreglo[29] = {'autor':'Isaac Asimov', 'frase':'La autoeducación es, creo firmemente, el único tipo de educación que hay.'};

	arreglo[30] = {'autor':'James Baldwin', 'frase':'Es casi imposible convertirse en una persona educada en un país tan desconfiado de la mente independiente.'};

	arreglo[31] = {'autor':'Ali', 'frase':'No hay riqueza como el conocimiento, no hay pobreza como la ignorancia.'};

	arreglo[32] = {'autor':'Séneca', 'frase':'Largo es el camino de la enseñanza por medio de teorías, breve y eficaz por medio de ejemplos.'};

	arreglo[33] = {'autor':'Séneca', 'frase':'Estudia no para saber una cosa más, sino para saberla mejor.'};

	var q = arreglo.length;

	var random = Math.round(Math.random()*(q -1));

	document.getElementById('frase').innerHTML= arreglo[random].frase;
	document.getElementById('autor').innerHTML= arreglo[random].autor;
	
}

fraseAleatoria();

$('#frmAcceso').on('submit', function (e) {
	e.preventDefault();
	
	var documento = $('#documento').val();
	var cedula = $('#user').val();
	var user = documento+cedula;
	var pass = $('#pass').val();

	$.post('../controladores/usuario.php?op=verificar', {'user': user, 'pass': pass}, function (data) {
		if (data!= 'null') {
			$(location).attr('href', 'escritorio.php');
		}
		else{
			const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'error',
				  title: 'Usuario o contraseña incorrectos ._.'
				});
		}
	});
});
