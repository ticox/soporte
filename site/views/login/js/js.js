$(document).ready(function(){


$('#empresa').hide();
$('#empresa_botton').hide();


$(document).on("click", "#verificar", function(){

		$.post(base_url+'login/verificar_user',{

						usuario:$("#usuario").val(),
						clave:$("#clave").val()

						},function(datos) {
						
						if(datos==0){

							alert("Por Favor, Verifique su Usuario y Clave.");
						}else{

							for (var i=0; i < datos.length; i++) {
			 						$('#select_empresa').append("<option  value="+datos[i].id_role+">"+datos[i].nombre_role+"</option>");
			 				}
						
						$('#empresa').show(1000); //muestro mediante id
						$('#empresa_botton').show(1000); //muestro mediante id
							}

				    },'json');


});


$(document).on("change", "#select_empresa", function(){

	jQuery("#entrar").removeAttr("disabled");

});


});