$(document).ready(function(){

//lector de codigos QR
scaner_qr('.xx');



//creacion de codigos QR
document.getElementById('qr').innerHTML = create_qrcode("123456");


//iniciar la validacion
//-----------------------------------------------------------


$('#prueba_campo').addClass('validate[required]');// asignacion de clase al campo para su verificacion
$('#prueba').validationEngine();//inicializacion de del form para su verificacion


//si el el envio de datos el directamente por el metodo post o get con el evento submit, no habla que realizar mas nada si no..

//hay que manejar el evento de validationengine validationEngine('validate') el cual debuelve true o false

$(document).on('click', '#validar', function() {
	$('#prueba').validationEngine('validate');
});

			

                        
                            
//-----------------------------------------------------------




});