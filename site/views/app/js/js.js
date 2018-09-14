$(document).ready(function(){



$('#usuario_existe').hide();
$('#usuario_disponible').hide();
$('#pass_no_coinciden').hide();

$('#verificado').hide();


	var accion=0;


$(document).on("change","#permisos_ch",function(){

console.log("menu--"+this.dataset.menu);
console.log("rol--"+this.dataset.rol);
console.log(this.checked);

$.get(base_url+"app/permisos_ch",{

'menu'        : this.dataset.menu,
'rol'         : this.dataset.rol,
'estado'      : this.checked

});



});



$(document).on("click", "#guardar_menu", function(){
	
	menu=$("#menu").val();
	enlace=$("#enlace").val();
	$.post(base_url + 'app/registrar_menu',{
		menu: menu,
		enlace: enlace
			},function(){
				alertify.success('Menu Registrado Correctamente');
				document.location=base_url+"app";
	           });
});


$(document).on("click", "#guardar_rol", function(){
	
	rol=$("#rol").val();
	$.post(base_url + 'app/registrar_rol',{
		rol: rol
			},function(){
				alertify.success('Rol Registrado Correctamente');
				//document.location=base_url+"app";
	           });
});

$(document).on("click", "#btn_actv", function(){
	
		$.post(base_url + 'app/updonw',
			{

			fecha: $("#fecha_activo").val(),
			accion: accion
			
			},function(){
				document.location=base_url+"app";		
	           });


});

$(document).on("click", "#radio1", function(){
	
if (this.value=="activar") {

accion="1";
$("#fecha_activo").attr('disabled', 'true');
}
else{

accion="0";
$("#fecha_activo").removeAttr("disabled")

}


});


$('#usuario').focus(function() {
    
$('#usuario_existe').hide();
$('#usuario_disponible').hide();
$('#pass_no_coinciden').hide();

$('#verificado').hide();
$("#guardar_usuario").attr("disabled","true");

  });
$('#contraseña').focus(function() {
    


$('#pass_no_coinciden').hide();

$('#verificado').hide();

$("#guardar_usuario").attr("disabled","true");
  });
$('#confirmar_contraseña').focus(function() {
    
$('#pass_no_coinciden').hide();

$('#verificado').hide();
$("#guardar_usuario").attr("disabled","true");

  });



$('#usuario').focusout(function() {


	if($("#usuario").val()==''){



	}else{


    $.post(base_url+'app/verificar_login',{

						usuario:$("#usuario").val()

						},function(datos) {
						
							if(datos.id_usuario>0){

								$('#usuario_existe').show(500);
								$('#usuario_disponible').hide();
								$("#verificar_usuario").val("0");
							}else{
								$('#usuario_existe').hide();
								$('#usuario_disponible').show(500);
								$("#verificar_usuario").val("1");
							}
						

						if($("#verificar_clave").val()==1 && $("#verificar_usuario").val()==1 ){

								  $('#guardar_usuario').removeAttr("disabled");
							}else{

								$("#guardar_usuario").attr("disabled","true");
							}



						
					},'json');



		
	}
    

  });


  

$('#confirmar_contraseña').focusout(function() {
    

	if($("#confirmar_contraseña").val()==''){



	}else{
						
							if($('#contraseña').val()==$('#confirmar_contraseña').val()){

								$('#pass_no_coinciden').hide();	
								$('#verificado').show(500);
								 $("#verificar_clave").val("1");
							}else{
								$('#pass_no_coinciden').show(500);	
								$('#verificado').hide();	
								$("#verificar_clave").val("0");
							}


						if($("#verificar_clave").val()==1 && $("#verificar_usuario").val()==1 ){

								  $('#guardar_usuario').removeAttr("disabled");
							}else{

								$("#guardar_usuario").attr("disabled","true");
							}


}
    

  });
  

$(document).on('click', '#guardar_usuario', function() {
	 		
	 		
			    	$.post(base_url+'app/guardar_usuario',{

						usuario:$("#usuario").val(),
						clave:$("#contraseña").val()

						},function() {
						$('#usuario_disponible').hide();
						$('#verificado').hide();	
						$("#contraseña").val("");
						$("#usuario").val("");
						$("#confirmar_contraseña").val("");
						alertify.success('Usuario Creado satisfactoriamente');
					});
		
	});




function mostrar_usuarios(usuario){
	$.post(base_url + 'app/buscar_usuario',{
		usuario: usuario
			},function(datos){
			console.log(datos);
			var html=" <br><div class='panel panel-default'>";
			html+="<div class='panel-heading'>";
			html+=" <h3 class='panel-title'><center><b>Resultado - Usuarios</b></center></h3>";
			html+="</div>";
			html+="<div class='panel-body'>";
			html+="<div class='table-responsive'>";
			
			html+="<table class='table table-striped table-hover '><thead>";
			html+="<tr class='default'>";
			html+="<th>Nombre</th>";
			html+="<th>Cedula</th>";
			html+="<th>login</th>";
			html+="<th>Acciones</th>";
			html+="</tr>";
			html+="</thead>";
			html+="<tbody>";
		if(datos==""){
			
			html+="<tr><td colspan='5'> <b><center>No Se Encontraron Usuarios</center></b></td></tr>";
			html+="</tbody> </table> </div> </div> </div>";
			$("#div_contenedor").html("");
			$("#div_contenedor").html(html);
			exit();
			}	
			for(var i = 0; i < datos.length; i++)
			{	
			html+="<tr><td>" + datos[i].login + "</td>";
			html+="<td>" + datos[i].login + "</td>";
			html+="<td>" + datos[i].login + "</td>";
			html+="<td><a id='eliminar_usuario' data-toggle='tooltip' data-placement='bottom' title='Eliminar Usuario' data-id_usuario='"+datos[i].id_usuario+"'><span class='glyphicon glyphicon-trash'></span></a>";
			html+=" <a data-toggle='modal' id='asignar_empresa' data-target='#modalasignar' title='Asignar Empresa' data-login='"+datos[i].login+"' data-id_usuario='"+datos[i].id_usuario+"'><span class='glyphicon glyphicon-plus'></span></a>";
			html+=" <a data-toggle='modal' id='ver_empresas' data-target='#modalempresas' title='Ver Empresas' data-login='"+datos[i].login+"' data-id_usuario='"+datos[i].id_usuario+"'><span class=' glyphicon glyphicon-th-list'></span></a></td>";
			

			}
			
			html+="</tbody> </table> </div> </div> </div>";
			$("#div_contenedor").html("");
			$("#div_contenedor").html(html);
				
	           },"json");
};




$(document).on("keyup", "#buscar_usuario", function(){
	usuario=$("#buscar_usuario").val();
	mostrar_usuarios(usuario);

});


$(document).on('click', '#asignar_empresa', function() {
	 		
	 		var login=this.dataset.login;
	 		var user=this.dataset.id_usuario;

	 		$.post(base_url + 'app/buscar_empresas', function(datos){
				var html="<center>Asignar Empresa para: "+login+" </br> </center></br>";
				html+="<select class='form-control' id='empresas'>";
				for (var i =0; datos.length>i; i++) {
					html+="<option value="+datos[i].id_role+">"+datos[i].nombre_role+"</option>";
				}

				html+="</select></br> <input type='hidden' id='id_usuario' value='"+user+"'> ";

				 $("#a_empresas").html("");
				 $("#a_empresas").html(html);
	           },'json');
			    	
		
	});


$(document).on('click', '#asignar_empresa_usuario', function() {
	 		alertify.confirm( "¿Esta realmente seguro de asignar esta empresa a este usuario?", function (e) {
			    if (e) {
			    	$.post(base_url+'app/asignar_empresa_usuario',{

						usuario:$("#id_usuario").val(),
						role:$("#empresas option:selected").val()

						},function() {
						alertify.success('Empresa asignada satisfactoriamente');

						$("#modalasignar .close").click();
					});
			        
			    } else {
			       alertify.error('Ha cancelado la operación');
			    }
			});  
			    	
		
	});



function mostrar_empresas(usuario){
	$.post(base_url + 'app/buscar_empresas_usuario',{
		usuario: usuario
			},function(datos){

			console.log(datos);
			var html=" <br><div class='panel panel-default'>";
			html+="<div class='panel-heading'>";
			html+=" <h3 class='panel-title'><center><b>Resultado</b></center></h3>";
			html+="</div>";
			html+="<div class='panel-body'>";
			html+="<div class='table-responsive'>";
			
			html+="<table class='table table-striped table-hover '><thead>";
			html+="<tr class='default'>";
			html+="<th>#</th>";
			html+="<th>Empresa</th>";
			html+="<th>Acciones</th>";
			html+="</tr>";
			html+="</thead>";
			html+="<tbody>";
		if(datos==""){
			
			html+="<tr><td colspan='5'> <b><center>El usuario no posee empresas asociadas</center></b></td></tr>";
			html+="</tbody> </table> </div> </div> </div>";
			$("#ver_empresas_usuario").html("");
			$("#ver_empresas_usuario").html(html);
			exit();
			}	
			for(var i = 0; i < datos.length; i++)
			{	
			html+="<tr><td>" + (i+1) + "</td>";
			html+="<td>" + datos[i].nombre_role +"</td>";
			html+="<td><a id='eliminar_empresa_usuario' data-toggle='tooltip' data-placement='bottom' title='Desafiliar esta empresa' data-id_role='"+datos[i].id_role+"' data-id_usuario='"+usuario+"'><span class='glyphicon glyphicon-trash'></span></a></td>";	
			}
			
			html+="</tbody> </table> </div> </div> </div>";
			$("#ver_empresas_usuario").html("");
			$("#ver_empresas_usuario").html(html);
				
	           },"json");
};

$(document).on('click', '#ver_empresas', function() {
	 		
	 		var user=this.dataset.id_usuario;

	 		mostrar_empresas(user);		    	
		
	});


/* ------------------------Eliminar Usuario-----------------*/

$(document).on('click', '#eliminar_usuario', function() {

	var user=this.dataset.id_usuario;
	 		
	 		alertify.confirm( "¿Esta realmente seguro de eliminar este usuario?", function (e) {
			    if (e) {
			    	$.post(base_url+'app/eliminar_usuario',{

						usuario:user

						},function() {
						alertify.success('Usuario Eliminado satisfactoriamente');

						$("#div_contenedor").html("");
					});
			        
			    } else {
			       alertify.error('Ha cancelado la operación');
			    }
			});   	
		
	});




/* ------------------------Eliminar empresa a Usuario-----------------*/
$(document).on('click', '#eliminar_empresa_usuario', function() {

	var user=this.dataset.id_usuario;
	var role=this.dataset.id_role;
	 		
	 		alertify.confirm( "¿Esta realmente seguro de eliminarle esta empresa a este usuario?", function (e) {
			    if (e) {
			    	$.post(base_url+'app/eliminar_empresa_usuario',{

						usuario:user,
						role:role

						},function() {
						alertify.success('Empresa eliminada al usuario satisfactoriamente');

						$("#modalasignar .close").click();
					});
			        
			    } else {
			       alertify.error('Ha cancelado la operación');
			    }
			});   	
		
	});


});