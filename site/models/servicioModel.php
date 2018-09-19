<?php

class servicioModel extends Model
{
    public function __construct() {
        parent::__construct();
    }



    public function registrar_servicio($datos){

 	 $sql="INSERT INTO servicio values ('','".$datos['servicio']."','".$datos['software']."' ,'".$datos['hardware']."' ,'".$datos['funcionamiento']."' ,'".$datos['otros']."' , curdate() , curtime(),'".session::get('id_usuario')."','".$datos['fecha_atencion']."' ,'".$datos['hora_atencion']."' ,'pendiente')";
        $this->_db->query($sql);
   }


   public function buscar_servicios_usuarios(){

 	 $sql="select * from servicio where id_usuario='".Session::get('id_usuario')."'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetchall();

   }

   public function buscar_servicio_usuario($servicio,$estatus){

    if($estatus=="solucionado"){

    $sql="select servicio.*, solucion_servicio.* from servicio, solucion_servicio where servicio.estatus='solucionado' and servicio.id_servicio=solucion_servicio.id_servicio and servicio.id_servicio=$servicio";
     $datos =  $this->_db->query($sql);
    }else{

      $sql="select * from servicio where id_servicio='".$servicio."'";
     $datos =  $this->_db->query($sql);

    }

      return $datos->fetch();
   }

     


   
    


}?>
