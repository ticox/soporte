$(document).ready(function(){
var software=0;
var hardware=0;
var funcionamiento=0;
var otros=0;
$("#servicio").focus();
$(".gift2").hide();
$("#divotros").hide();


 $("#enviar_solicitudes").click(function() {  

var cont=0;
 	if($("#software").is(':checked')) {  
         software=1;
         cont++;
        }

    if($("#hardware").is(':checked')) {  
         hardware=1;   
        cont++;
        }
    if($("#funcionamiento").is(':checked')) {  
         funcionamiento=1;   
        cont++;
        }
    if($("#otros").is(':checked')) {  
         otros=1;   
        cont++;
        }

        $(".gift2").show();
 $.post(base_url + 'servicio/registrar_servicio',{
		servicio:$('#servicio').val(),
		software: software,
		hardware:hardware,
		funcionamiento:funcionamiento,
		otros:$('#otrosrespuesta').val(),
		hora_atencion:$('#hora_atencion').val(),
		fecha_atencion:$('#fecha_atencion').val()
			},function(){
				$(".gift2").hide();
				alertify.success('Pedido de servicio enviado correctamente.');

 				setTimeout('document.location.reload()',2000);
          });


    });  



$(document).on("change","#otros",function(){

 if($("#otros").is(':checked')) {  
        
        $("#divotros").show(1000);
        }else{

        	$("#divotros").hide(1000);
        }


});



$(document).on('click', '#detalles_servicio', function() {

var servicio=this.dataset.id_servicio;
var estatus=this.dataset.estatus;
	$.post(base_url + 'servicio/buscar_servicio_usuario',{
			servicio: servicio,
			estatus:estatus
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
			
			var newfecha = datos.fecha_inicio.split('-').reverse().join('/');
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

			html+="<i class='online'>Tarea Conluida: El  Dia <b>"+newfecha+" </b>, Se inició a las <b>"+datos.hora_inicio+" </b> y finalizo <b>"+datos.hora_solucion+"</b> <br> Duracion: "+horas+" Horas y "+minutos+" Minutos . </i>";

			  



			html+="</div>";

			}else {
			html+="</div>";

			}
			

			$("#ver_servicio").html("");
			$("#ver_servicio").html(html);
				
	           },"json");
    });  



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
      $('#list').after('<div id="prevista" class="col-md-12 prviuw"> <center><img class="zoom" id="imagen2" width="300px" height="150px" src="'+this.result+' " ></center></div> <br>' );
    }
    reader[i].readAsDataURL(input.files[i]);
  }

  console.log(reader);
  
}

$(document).on("change", "#cargar_imagen", function(){

archivo(this);
});


});