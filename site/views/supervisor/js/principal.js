$(document).ready(function(){
var software=0;
var hardware=0;
var funcionamiento=0;
var otros=0;
$("#servicio").focus();

$(".gift2").hide();


 $("#enviar_solicitud").click(function() {  

 	if($("#software").is(':checked')) {  
         software=1;   
        }

    if($("#hardware").is(':checked')) {  
         hardware=1;   
        }
    if($("#funcionamiento").is(':checked')) {  
         funcionamiento=1;   
        }
    if($("#otros").is(':checked')) {  
         otros=1;   
        }

 $.post(base_url + 'servicio/registrar_servicio',{
		servicio:$('#servicio').val(),
		software: software,
		hardware:hardware,
		funcionamiento:funcionamiento,
		otros:otros
			},function(){
				alertify.success('Pedido de servicio enviado correctamente.');

 				setTimeout('document.location.reload()',3000);
          });


    });  


 $(document).on('click', '#cambiar_estatus', function() {

	var servicio=this.dataset.id_servicio;
	$.post(base_url + 'admin_servicios/buscar_servicio_usuario',{
			servicio: servicio
			},function(datos){
	
			var html=" <br><div class='panel panel-default'>";
			html+="<div class='panel-heading'>";
			html+=" <h3 class='panel-title'><center><b>Servicio Solicitado:</b>";
			if(datos.fecha_atencion!=''){
				var newfecha3 = datos.fecha_atencion.split('-').reverse().join('/');
				html+="<br>Tentativamente para el dia: "+newfecha3+" a las "+datos.hora_atencion;
			}
			html+="</center></h3>";
			html+="</div>";
			html+="<div class='panel-body'>";

			html+="<p>"+datos.pedido+"</p>";
			html+="<div class='table-responsive'>";
			
			html+="<table class='table table-striped table-hover'><thead>";
			html+="<tr class='default'>";
			html+="<th>Mantenimiento de software</th>";
			html+="<th>Mantenimiento de hardware</th>";
			html+="<th>Pruebas de funcionamiento</th>";
			html+="<th>Otros</th>";
			html+="</tr>";
			html+="</thead>";
			html+="<tbody>";
		
			if(datos.software==1){
				html+="<tr><td>SI</td>";
			}else{
				html+="<td>NO</td>";
			}
			if(datos.hardware==1){
				html+="<td>SI</td>";
			}else{
				html+="<td>NO</td>";
			}
			if(datos.funcionamiento==1){
				html+="<td>SI</td>";
			}else{
				html+="<td>NO</td>";
			}
			if(datos.otros=='0'){
				html+="<td>NO</td>";
			}else{
				html+="<td>SI</td>";
			}
			html+="</tr>";
			if(datos.otros!='0'){
				html+="<tr><td colspan='4'><b>Otros:</b> "+datos.otros+"</td><tr>";
			}
			
			html+="</tbody> </table>";
			html+="</div>";
			if(datos.imagen_pedido!=''){
       		html+="<div class='col-md-12'><center><img class='zoom mostrar_img' id='imagen2' width='400px' height='200px' src=' "+base_url+"public/img/problemas/"+datos.imagen_pedido+"' ></center></div>";
			}

			html+="<i><b>Observaciones/Actividades:</b></i>";
			html+="<textarea id='observacion' name='observacion' class='form-control' placeholder='Agregue la observacion aqui...' required='true'></textarea>";
			html+="<br><p><b>Adjuntar imagen/Foto:</b><input type='file' accept='image/*' id='cargar_imagen' name='foto[]' capture='camera'> <br>";
			html+="<div id='list' class='col-md-12 titulo-img'><center> <h4> Previsualización </h4> </center></div><br>"; 
			html+="<i><b>Cambiar Estatus:</b></i>";
			html+="<select id='estatus' name='estatus' class='form-control' required='true'> <option value=''>--Seleccione--</option> <option value='pendiente'>Pendiente</option> <option value='solucionado'>Solucionado</option> </select>"
			html+="<input type='hidden' id='id_servicio' name='id_servicio' value='"+servicio+"'><input type='hidden' id='servicio_solicitado' value='"+datos.pedido+"'>";
			html+="<input type='hidden' id='correo' name='correo' value='"+datos.correo+"'><input type='hidden' id='nombre' name='nombre' value='"+datos.nombre+" "+datos.apellido+ "'>";
			html+="<p><b>Configure la hora de inicio del servicio:</b></p> <input type='time' id='hora_inicio' class='form-control' name='hora_inicio' required='true'><p><b>Configure la hora final del servicio:</b></p> <input type='time' id='hora_fin' class='form-control' name='hora_fin' required='true'>";
			html+="</div>";
			
			$("#ver_servicio_pendiente").html("");
			$("#ver_servicio_pendiente").html(html);
				
	           },"json");
    });  


$(document).on('click', '#cambiar_estatus_servicio', function() {

			$(".gift2").show();
	$.post(base_url + 'admin_servicios/cambiar_estatus_servicio',{
			servicio:$('#id_servicio').val(),
			observacion:$('#observacion').val(),
			estatus:$('#estatus').val(),
			correo:$('#correo').val(),
			pedido:$('#servicio_solicitado').val(),
			nombre:$('#nombre').val()
			},function(){
				$(".gift2").hide();
				alertify.alert("cambio hecho exitosamente");
				setTimeout('document.location.reload()',2000);
	           });
    });  

$(document).on('click', '#detalles_servicio', function() {

var servicio=this.dataset.id_servicio;
	$.post(base_url + 'admin_servicios/buscar_servicio_solucionado',{
			servicio: servicio
			},function(datos){
			var html=" <br><div class='panel panel-default'>";
			html+="<div class='panel-heading'>";
			html+=" <h3 class='panel-title'><center><b>Servicio Solicitado:</b></center></h3>";
			html+="</div>";
			html+="<div class='panel-body'>";

			html+="<p>"+datos.pedido+"</p>";
			html+="<div class='table-responsive'>";
			
			html+="<table class='table table-striped table-hover'><thead>";
			html+="<tr class='default'>";
			html+="<th>Mantenimiento de software</th>";
			html+="<th>Mantenimiento de hardware</th>";
			html+="<th>Pruebas de funcionamiento</th>";
			html+="<th>Otros</th>";
			html+="</tr>";
			html+="</thead>";
			html+="<tbody>";
		
			if(datos.software==1){
				html+="<tr><td>SI</td>";
			}else{
				html+="<td>NO</td>";
			}
			if(datos.hardware==1){
				html+="<td>SI</td>";
			}else{
				html+="<td>NO</td>";
			}
			if(datos.funcionamiento==1){
				html+="<td>SI</td>";
			}else{
				html+="<td>NO</td>";
			}
			if(datos.otros=='0'){
				html+="<td>NO</td>";
			}else{
				html+="<td>SI</td>";
			}
			html+="</tr>";
			if(datos.otros!='0'){
				html+="<tr><td colspan='4'><b>Otros:</b> "+datos.otros+"</td><tr>";
			}
			
			html+="</tbody> </table>";
			html+="</div>";
			if(datos.imagen_pedido!=''){
       		html+="<div class='col-md-12'><center><img class='zoom mostrar_img' id='imagen2' width='400px' height='200px' src=' "+base_url+"public/img/problemas/"+datos.imagen_pedido+"' ></center></div>";
			}


			if(datos.estatus=="solucionado"){
			
			html+="<tr><td colspan='5'><table class='table table-striped table-hover'><thead>";
			html+="<tr class='default'>";
			html+="<th>Observaciones/Actividades</th></tr>";
			html+="</thead>";
			html+="<tbody>";
			html+="<tr><td>"+datos.observacion+"</td></tr>";
			html+="</tbody></table></td></tr>";
			
			
			}	
			
			html+="</tbody> </table> </div>";
			if(datos.estatus=="solucionado"){
			
			var newfecha = datos.fecha_solucion.split('-').reverse().join('/');
       		if(datos.imagen_solucion!=''){
       		html+="<div class='col-md-12'><center><img class='zoom mostrar_img' id='imagen2' width='400px' height='200px' src=' "+base_url+"public/img/soluciones/"+datos.imagen_solucion+"' ></center></div>";
			}

			inicio = datos.hora_inicio;
			  fin = datos.hora_solucion;
			  inicioMinutos = parseInt(inicio.substr(3,2));
			  inicioHoras = parseInt(inicio.substr(0,2));
			  
			  finMinutos = parseInt(fin.substr(3,2));
			  finHoras = parseInt(fin.substr(0,2));

			  transcurridoMinutos = finMinutos - inicioMinutos;
			  transcurridoHoras = finHoras - inicioHoras;
			  
			  if (transcurridoMinutos < 0) {
			    transcurridoHoras--;
			    transcurridoMinutos = 60 + transcurridoMinutos;
			  }
			  
			  horas = transcurridoHoras.toString();
			  minutos = transcurridoMinutos.toString();
			  
			  if (horas.length < 2) {
			    horas = "0"+horas;
			  }
			  
			  if (horas.length < 2) {
			    horas = "0"+horas;
			  }
			  
			  horas+":"+minutos;

			html+="<i class='online'>Tarea conluida por "+ datos.nombre+" "+datos.apellido+". <br>El  Dia <b>"+newfecha+" </b>, Se inició a las <b>"+datos.hora_inicio+" </b> y finalizo <b>"+datos.hora_solucion+".</b> <br> Duracion: "+horas+" Horas y "+minutos+" Minutos. </i>";

			  
			html+="</div>";

			}else {
			html+="</div>";

			}

			$("#ver_servicio").html("");
			$("#ver_servicio").html(html);
				
	           },"json");
    });  


$(document).on("click", "#buscar_x_fecha", function(){
	fecha1=$("#fecha1").val();
	fecha2=$("#fecha2").val();
	mostrar_servicios_solucionados(fecha1,fecha2);

});


function mostrar_servicios_solucionados(fecha1,fecha2){
	$.post(base_url + 'supervisor/buscar_x_fecha',{
		fecha1: fecha1,
		fecha2: fecha2
			},function(datos){
			console.log(datos);
			var html="<div class='table-responsive'>";
			html+="<table class='table table-striped table-hover '><thead>";
			html+="<tr class='default'>";
			html+="<th>#</th>";
			html+="<th>Usuario</th>";
			html+="<th>Servicio</th>";
			html+="<th>Fecha de solución</th>";
			html+="<th>Hora de atención</th>";
			html+="<th>Duración</th>";
			html+="<th>Acciones</th>";
			html+="</tr>";
			html+="</thead>";
			html+="<tbody>";
		if(datos==""){
			
			html+="<tr><td colspan='8'> <b><center>No Se Encontraron Resultados</center></b></td></tr>";
			html+="</tbody> </table> </div>";
			$("#div_contenedor").html("");
			$("#div_contenedor").html(html);
			exit();
			}	
			for(var i = 0; i < datos.length; i++)
			{	
			var str = datos[i].pedido;
			var res = str.slice(0, 50);

			  var inicio = datos[i].hora_inicio;
			  var fin = datos[i].hora_solucion;
			   var inicioMinutos = parseInt(inicio.substr(3,2));
			  var inicioHoras = parseInt(inicio.substr(0,2));
			  
			 var finMinutos = parseInt(fin.substr(3,2));
			  var finHoras = parseInt(fin.substr(0,2));

			  var transcurridoMinutos = finMinutos - inicioMinutos;
			  var transcurridoHoras = finHoras - inicioHoras;
			  
			  if (transcurridoMinutos < 0) {
			    transcurridoHoras--;
			    transcurridoMinutos = 60 + transcurridoMinutos;
			  }
			  
			  horas = transcurridoHoras.toString();
			  minutos = transcurridoMinutos.toString();
			  
			  if (horas.length < 2) {
			    horas = "0"+horas;
			  }
			  
			  if (minutos.length < 2) {
			    minutos = "0"+minutos;
			  }
			  
			  var duracion=horas+":"+minutos;
			var newfecha = datos[i].fecha_solucion.split('-').reverse().join('/');
			html+="<tr><td>" + (i+1); + "</td>";
			html+="<td>" + datos[i].nombre +" "+datos[i].apellido+"</td>";
			html+="<td>" + res +"...</td>";
			html+="<td>" + newfecha + "</td>";
			html+="<td>" + datos[i].hora_inicio+"-"+datos[i].hora_solucion+"</td>";
			html+="<td>" + duracion + "</td>";
			html+="<td><a href='javascript:null()' data-toggle='modal' data-target='#modalservicio' id='detalles_servicio' data-id_servicio="+datos[i].id_servicio+"><span class='glyphicon glyphicon-list'></span>Detalles</a></td>";
			}
			
			html+="</tbody> </table> </div>";
			$("#div_contenedor").html("");
			$("#div_contenedor").html(html);
				
	           },"json");
};





/*-----------------------------Cargar Imagen en el sistema--------------------------*/




function archivo(input)
{
  $("div#prevista").remove();
  $('#list').addClass('active');
  reader=Array();
  for (var i = 0; i < input.files.length ;  i++)
  {
    reader[i] = new FileReader();
    reader[i].numero= i;
    reader[i].onloadstart= function(){

      $('#list').after('<div id="cargarr'+this.numero+'" class="col-xs-6 col-sm-4 col-md-12 col-lg-2 ">img ==='+this.numero+'</div>' );

    }
    reader[i].onloadend= function(){

      $('div#cargarr'+this.numero).remove();
    }
    reader[i].onload= function()
    {
      $('#list').after('<div id="prevista" class="col-md-12 prviuw"> <center><img class="zoom" id="imagen2" width="400px" height="200px" src="'+this.result+' " ></center></div> <br>' );
    }
    reader[i].readAsDataURL(input.files[i]);
  }

  console.log(reader);
  
}


$(document).on("change", "#cargar_imagen", function(){


archivo(this);
});

});