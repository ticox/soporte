$(document).ready(function(){
var software=0;
var hardware=0;
var funcionamiento=0;
var otros=0;
$("#servicio").focus();
$(".gift2").hide();


 $("#enviar_solicitud").click(function() {  

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

if($('#servicio').val()=='' || cont==0){

alertify.alert("Por favor Llene el pedido y/o seleccione por lo menos un motivo.")
exit();
}
        $(".gift2").show();
 $.post(base_url + 'servicio/registrar_servicio',{
		servicio:$('#servicio').val(),
		software: software,
		hardware:hardware,
		funcionamiento:funcionamiento,
		otros:otros,
		hora_atencion:$('#hora_atencion').val(),
		fecha_atencion:$('#fecha_atencion').val()
			},function(){
				$(".gift2").hide();
				alertify.success('Pedido de servicio enviado correctamente.');

 				setTimeout('document.location.reload()',2000);
          });


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
			html+="<th>otros</th>";
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
			if(datos.otros==1){
				html+="<td>SI</td>";
			}else{
				html+="<td>NO</td>";
			}
			html+="</tr>";
		

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
       		html+="<div class='col-md-12'><center><img class='zoom' id='imagen2' width='400px' height='200px' src=' "+base_url+"public/img/soluciones/"+datos.imagen_solucion+"' ></center></div>";
			}
			html+="<i class='online'>Tarea Conluida: El  Dia <b>"+newfecha+" </b> A las <b>"+datos.hora_solucion+"</b> </i>";
			
			html+="</div>";

			}else {
			html+="</div>";

			}

			$("#ver_servicio").html("");
			$("#ver_servicio").html(html);
				
	           },"json");
    });  




});