$(function () {
    $('.datepicker').datepicker({
        language: 'es',
    });
});


var extensionesValidas = ".png, .svg, .jpeg, .jpg";
var pesoPermitido = 512;

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;

    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}


//image validate
function validarExtension(datos) {
	var ruta = datos.value;
	var extension = ruta.substring(ruta.lastIndexOf('.') + 1).toLowerCase();
	var extensionValida = extensionesValidas.indexOf(extension);

	if(extensionValida < 0) {
            $('.has-danger-image').text('La extensión no es válida Su fichero tiene de extensión: .'+ extension).css("color", "red");
            return false;
        } else {
            $('.has-danger-image').text('');
            return true;
        }
    }

   // Validacion de peso del fichero en kbs
    function validarPeso(datos) {
        if (datos.files && datos.files[0]) {
            var pesoFichero = datos.files[0].size/1024;

            if(pesoFichero > pesoPermitido) {
                $('.has-danger-image').text('El peso maximo permitido del fichero es: ' + pesoPermitido + ' KBs Su fichero tiene: '+ pesoFichero +' KBs').css("color", "red");
                return false;
            } else {
                $('.has-danger-image').text('');
                return true;
            }
	    }
    }

  // Vista preliminar de la imagen.
  function verImagen(datos, elemento) {

      if (datos.files && datos.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
	          $('#avatar').attr('src', e.target.result);
          };
          reader.readAsDataURL(datos.files[0]);
       }
   }
