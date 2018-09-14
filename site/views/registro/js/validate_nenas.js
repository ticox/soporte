$(document).ready(function(){

$('#nombre').addClass('validate[required]');
$('#destrezas').addClass('validate[required]');
$('#especialidad').addClass('validate[required]');
$('#preview').addClass('validate[required]');
$('#estatura').addClass('validate[required]');
$('#medidas').addClass('validate[required]');
$('#peso').addClass('validate[required]');
$('#color_cabello').addClass('validate[required]');
$('#color_ojos').addClass('validate[required]');
$('#color_piel').addClass('validate[required]');
$('#fecha_nacimiento').addClass('validate[required]');
$('#horario').addClass('validate[required]');
$('#localidad').addClass('validate[required]');
$('#email').addClass('validate[required]');
$('#telefono').addClass('validate[required]');
$('#files').addClass('validate[required]');
$('#tipo').addClass('validate[required]');
$('#inlineRadio1').addClass('validate[minCheckbox[1]]');
$('#inlineRadio2').addClass('validate[minCheckbox[1]]');
$('#inlineRadio3').addClass('validate[minCheckbox[1]]');



$('#agregar').validationEngine();

//$('#form_registro').validationEngine('validate');
				
			

});