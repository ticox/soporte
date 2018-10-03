<?php

class servicioModel extends Model
{
    public function __construct() {
        parent::__construct();
    }



    public function registrar_servicio($datos,$fotos){





$software=0;
$hardware=0;
$funcionamiento=0;
$otros=0;

if(isset($datos['software'])){
$software=1;
}

if(isset($datos['hardware'])){
$hardware=1;
}

if(isset($datos['funcionamiento'])){
$funcionamiento=1;
}

if(isset($datos['otros'])){
$otros=$datos['otrosrespuesta'];
}

    if($fotos['foto']['name'][0]==''){

        if(session::get('role')==1){

        $sql="INSERT INTO servicio values ('','".$datos['servicio']."','".$software."' ,'".$hardware."' ,'".$funcionamiento."','".$otros."' , curdate() , curtime(),'".$datos['id_usuario']."','".$datos['fecha_atencion']."' ,'".$datos['hora_atencion']."' ,'pendiente','')";
                  $this->_db->query($sql);
        }else{

          $sql="INSERT INTO servicio values ('','".$datos['servicio']."','".$software."' ,'".$hardware."' ,'".$funcionamiento."','".$otros."' , curdate() , curtime(),'".session::get('id_usuario')."','".$datos['fecha_atencion']."' ,'".$datos['hora_atencion']."' ,'pendiente','')";
            $this->_db->query($sql);

        }




    }else{

      $target_path = "public/img/problemas/";
                  $randon=mt_rand(1,1000);
                  $nombre='problema-'.$randon.$fotos['foto']['name'][0];
                  $target_path = $target_path .$nombre;
                  if(session::get('role')==1){
                  $sql="insert into servicio values('','".$datos['servicio']."','".$software."' ,'".$hardware."' ,'".$funcionamiento."' ,'".$otros."' , curdate() , curtime(),'".$datos['id_usuario']."','".$datos['fecha_atencion']."' ,'".$datos['hora_atencion']."' ,'pendiente','".$nombre."')";
                 $this->_db->query($sql);
                 }else{
                  $sql="insert into servicio values('','".$datos['servicio']."','".$software."' ,'".$hardware."' ,'".$funcionamiento."' ,'".$otros."' , curdate() , curtime(),'".session::get('id_usuario')."','".$datos['fecha_atencion']."' ,'".$datos['hora_atencion']."' ,'pendiente','".$nombre."')";
                 $this->_db->query($sql);
                 }
                  move_uploaded_file($fotos['foto']['tmp_name'][0], $target_path); 
                  $obj_img = new SimpleImage();
                  $obj_img->load($target_path);
                  //$obj_img->resize(234,135);
                  $obj_img->save($target_path);
}


   }


   public function buscar_servicios_usuarios(){

 	 $sql="select * from servicio where id_usuario='".Session::get('id_usuario')."'";
  
     $datos =  $this->_db->query($sql);
      return $datos->fetchall();

   }



public function buscar_usuarios(){

   $sql="select * from usuario where id_role!=1 order by login ASC";
  
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
