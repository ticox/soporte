<?php

class supervisorModel extends Model
{
    public function __construct() {
        parent::__construct();
    }




   public function buscar_servicios_admin(){

 	 $sql="select servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario where servicio.id_usuario=usuario.id_usuario and servicio.estatus='pendiente'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetchall();

   }

   public function buscar_servicios_admin_solucionados(){

   $sql="select servicio.*, solucion_servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario, solucion_servicio where servicio.id_usuario=usuario.id_usuario and servicio.estatus='solucionado' and servicio.id_servicio=solucion_servicio.id_servicio and usuario.empresa='".session::get('empresa')."'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetchall();

   }

   public function buscar_servicio_usuario($servicio){

 	 $sql="select servicio.*, usuario.* from servicio, usuario where servicio.id_usuario=usuario.id_usuario and id_servicio='".$servicio."'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetch();

   }


   public function cambiar_estatus_servicio($datos,$fotos){
    if($fotos['foto']['name'][0]==''){

       $sql="insert into solucion_servicio values('','".$datos['observacion']."',curdate(), '".$datos['hora_fin']."','".$datos['id_servicio']."','','','".$datos['hora_inicio']."','".session::get('id_usuario')."')";
                  $this->_db->query($sql);
    }else{
      $target_path = "public/img/soluciones/";
                  $nombre='solucion-'.$fotos['foto']['name'][0];
                  $target_path = $target_path .$nombre;
                  $sql="insert into solucion_servicio values('','".$datos['observacion']."',curdate(), '".$datos['hora_fin']."','".$datos['id_servicio']."','".$nombre."','','".$datos['hora_inicio']."')";
                  $this->_db->query($sql);
                  move_uploaded_file($fotos['foto']['tmp_name'][0], $target_path); 
                  $obj_img = new SimpleImage();
                  $obj_img->load($target_path);
                  //$obj_img->resize(234,135);
                  $obj_img->save($target_path);
}
      $sql2="update servicio SET estatus='".$datos['estatus']."' WHERE id_servicio='".$datos['id_servicio']."'";
      $this->_db->query($sql2);
      return 0;
   }

public function buscar_x_fecha($fecha1,$fecha2){

   /* $sql="select servicio.*, solucion_servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario, solucion_servicio where servicio.id_usuario=usuario.id_usuario and servicio.estatus='solucionado' and servicio.id_servicio=solucion_servicio.id_servicio and and usuario.empresa=";*/

    $sql="select servicio.*, solucion_servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario, solucion_servicio where servicio.id_usuario=usuario.id_usuario and servicio.estatus='solucionado' and servicio.id_servicio=solucion_servicio.id_servicio and usuario.empresa='".session::get('empresa')."' and solucion_servicio.fecha_solucion BETWEEN '".$fecha1."' and '".$fecha2."'";
     $datos =  $this->_db->query($sql);
  
      return $datos->fetchall();

   }  

   public function buscar_servicios_solucionados($nombre){
   
$sql="select servicio.*, usuario.nombre, usuario.apellido, usuario.empresa from servicio, usuario where servicio.id_usuario=usuario.id_usuario and usuario.nombre like '$nombre%' and servicio.estatus='solucionado'";
$datos = $this->_db->query($sql);
return $datos->fetchall();
}
    


}?>
