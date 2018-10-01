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

			    		cedula:$("#cedula").val(),
			    		nombre:$("#nombre").val(),
			    		apellido:$("#apellido").val(),
			    		correo:$("#correo").val(),
			    		empresa:$("#empresa").val(),
			    		departamento:$("#departamento").val(),
			    		role:$("#role_usuario").val(),
						usuario:$("#usuario").val(),
						clave:$("#contraseña").val()

						},function() {
						$('#usuario_disponible').hide();
						$('#verificado').hide();	
						$("#contraseña").val("");
						$("#cedula").val("");
						$("#nombre").val("");
						$("#correo").val("");
						$("#apellido").val("");
						$("#empresa").val("");
						$("#departamento").val("");
						$("#role_usuario").val("");
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
			html+="<th>CEDULA</th>";
			html+="<th>NOMBRES Y APELLIDOS</th>";
			html+="<th>EMPRESA</th>";
			html+="<th>LOGIN</th>";
			html+="<th>ROL</th>";
			html+="<th>ACCIONES</th>";
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
			html+="<tr><td>" + datos[i].cedula + "</td>";
			html+="<td>" + datos[i].nombre + " " + datos[i].apellido + "</td>";
			html+="<td>" + datos[i].empresa + "</td>";
			html+="<td>" + datos[i].login + "</td>";
			html+="<td>" + datos[i].rol + "</td>";
			html+="<td><a id='editar_usuario' data-toggle='modal' data-target='#modalusuario' data-toggle='tooltip' data-placement='bottom' title='Editar Usuario' data-login='"+datos[i].login+"' data-id_usuario='"+datos[i].id_usuario+"'><span class='glyphicon glyphicon-pencil'></span></a> <a id='eliminar_usuario' data-toggle='tooltip' data-placement='bottom' title='Eliminar Usuario' data-id_usuario='"+datos[i].id_usuario+"'><span class='glyphicon glyphicon-trash'></span></a></td>";
			

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


$(document).on('click', '#editar_usuario', function() {
	 		
	 		var login=this.dataset.login;
	 		var user=this.dataset.id_usuario;

	 		$.post(base_url + 'app/editar_usuario',{
			id_usuario: user
			},function(datos){
				var html="<center>USUARIO: <b>"+login+"</b> </br> </center></br>";

				$.post(base_url + 'app/buscar_roles', function(datos1){
		
				html+="<div class='col-md-12'><b><center>CEDULA: </center></b> </div>";
				html+="<div class='col-md-12'><input id='cedulax' class='form-control' value='"+datos.cedula+"'></div>";
				html+="<div class='col-md-6'><b>NOMBRES</b> </div> <div class='col-md-6'><b>APELLIDOS</b> </div>";
				html+="<div class='col-md-6'><input id='nombrex' class='form-control' value='"+datos.nombre+"'></div> <div class='col-md-6'><input id='apellidox' class='form-control' value='"+datos.apellido+"'></div>";
				html+="<div class='col-md-12'><b><center>CORREO: </center></b> </div>";
				html+="<div class='col-md-12'><input id='correox' class='form-control' value='"+datos.correo+"'></div>";
				html+="<div class='col-md-6'><b>EMPRESA</b> </div> <div class='col-md-6'><b>DEPARTAMENTO</b> </div>";
				html+="<div class='col-md-6'><input id='empresax' class='form-control' value='"+datos.empresa+"'></div> <div class='col-md-6'><input id='departamentox' class='form-control' value='"+datos.departamento+"'></div>";
				html+="<div class='col-md-12'><b><center>TIPO USUARIO: </center></b> </div>";
				html+="<div class='col-md-12'> <input type='text' value='"+user+"' id='id_usuario' hidden><select class='form-control' id='role'>";
				html+="<option value=''>--Seleccione--</option>";
				for (var i =0; datos1.length>i; i++) {
					if(datos1[i].id_role==datos.id_role){
					html+="<option value='"+datos1[i].id_role+"' selected>"+datos1[i].nombre_role+"</option>";
				}else{
					html+="<option value='"+datos1[i].id_role+"'>"+datos1[i].nombre_role+"</option>";
				}}

				html+="</select></div>";

				$("#e_usuario").html("");
				$("#e_usuario").html(html);
				
	           },'json');



				 
	           },'json');
			    	
		
	});





$(document).on('click', '#modificar_usuario', function() {
	 		alertify.confirm( "¿Esta realmente seguro de modificar la información de este usuario?", function (e) {
			    if (e) {
			    	$.post(base_url+'app/modificar_usuario',{

						cedula:$("#cedulax").val(),
						nombre:$("#nombrex").val(),
						apellido:$("#apellidox").val(),
						correo:$("#correox").val(),
						empresa:$("#empresax").val(),
						departamento:$("#departamentox").val(),
						rol:$("#role").val(),
						id_usuario:$("#id_usuario").val()

						},function() {
						alertify.success('Usuario modificado exitosamente');

						$("#modalusuario .close").click();
					});
			        
			    } else {
			       alertify.error('Ha cancelado la operación');
			    }
			});  
			    	
		
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

$(document).on('click', '#eliminar_usuario', function() {

	var id_usuario=this.dataset.id_usuario;
	 		alertify.confirm( "¿Esta realmente seguro de eliminar a este usuario?", function (e) {
			    if (e) {
			    	$.post(base_url+'app/eliminar_usuario',{

						usuario:id_usuario

						},function() {
						alertify.success('Usuario eliminado exitosamente.');
						 setTimeout('document.location.reload()',1000);
				
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




});