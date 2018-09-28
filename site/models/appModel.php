<?php

class appModel extends Model
{
    public function __construct() {
        parent::__construct();
    }

    

public function menu($id = false){

  if ($id!=false) {
    $sql = "SELECT menu.* FROM menu,permisos,role,usuario WHERE\n"
    . "menu.id_menu=permisos.id_menu and \n"
    . "role.id_role = permisos.id_role and\n"
    . "permisos.permiso=1 and \n"
    . "role.id_role=usuario.id_role and\n"
    . "usuario.id_usuario=".$id."\n"
    . "order by id_menu asc\n";
  $menu = $this->_db->query($sql);
  return $menu->fetchall();
    
  }else{
    $sql = "SELECT DISTINCT menu.* FROM menu,permisos,role,usuario WHERE\n"
    . "menu.id_menu=permisos.id_menu and \n"
    . "role.id_role = permisos.id_role and\n"
    . "permisos.permiso=1 and \n"
    . "role.id_role=2 \n"
    . "order by id_menu asc\n";
  $menu = $this->_db->query($sql);
  return $menu->fetchall();


  }
}


    public function traer_menus(){


    $sql="select * from menu";
       

        $datos = $this->_db->query($sql);
              //  $datos->setFetchMode(PDO::FETCH_ASSOC);

        return $datos->fetchall();


    }
      public function traer_roles(){


    $sql="select * from role";
       
        $datos = $this->_db->query($sql);
              //  $datos->setFetchMode(PDO::FETCH_ASSOC);

        return $datos->fetchall();

    }


 public function guardar_usuario($datos){

 $sql="INSERT INTO usuario values ('','".$datos['usuario']."' ,'" . Hash::getHash('sha1', $datos['clave'], HASH_KEY) ."','".$datos['cedula']."' ,'".$datos['nombre']."' ,'".$datos['apellido']."' ,'".$datos['correo']."' ,'".$datos['empresa']."' ,'".$datos['departamento']."' ,'1','".$datos['role']."')";
        $this->_db->query($sql);
   }


public function buscar_usuario($nombre){
   
$sql="select usuario.*, role.nombre_role as rol from usuario,role 
WHERE usuario.id_role=role.id_role and usuario.login 
like '$nombre%' ORDER by (nombre) ASC";
$datos = $this->_db->query($sql);
return $datos->fetchall();
}


public function editar_usuario($id_usuario){
   
$sql="select usuario.*, role.nombre_role as rol from usuario,role 
WHERE usuario.id_role=role.id_role and usuario.id_usuario=$id_usuario";
$datos = $this->_db->query($sql);
return $datos->fetch();
}

public function modificar_usuario($datos){

  $sql="UPDATE usuario SET cedula='".$datos['cedula']."', nombre='".$datos['nombre']."', apellido='".$datos['apellido']."', correo='".$datos['correo']."', empresa='".$datos['empresa']."', departamento='".$datos['departamento']."',id_role='".$datos['rol']."' WHERE id_usuario='".$datos['id_usuario']."'";
$datos = $this->_db->query($sql);
}




    public function verificar_login($usuario){


    $sql="select * from usuario where login='$usuario'";
       

            $datos = $this->_db->query($sql);
        //$datos->setFetchMode(PDO::FETCH_ASSOC);

       return $datos->fetch();
      


    }




public function buscar_empresas_usuario($id_usuario){


    $sql="select DISTINCT role.nombre_role, role.id_role from empresa_usuario, role, usuario where empresa_usuario.id_empresa=role.id_role and empresa_usuario.id_usuario=$id_usuario";

            $datos = $this->_db->query($sql);
        //$datos->setFetchMode(PDO::FETCH_ASSOC);

       return $datos->fetchall();
    

    }


    public function eliminar_usuario($id_usuario){


     $sql="delete FROM usuario where usuario.id_usuario=$id_usuario";

            $datos = $this->_db->query($sql);
        //$datos->setFetchMode(PDO::FETCH_ASSOC);
    

    }


    public function asignar_empresa_usuario($usuario, $role){

     $sql="insert into `empresa_usuario` VALUES ('',$role,$usuario)";
       
        $datos = $this->_db->query($sql);

        return ;


    }

    public function eliminar_empresa_usuario($usuario, $role){

    $sql="delete FROM empresa_usuario where empresa_usuario.id_usuario=$usuario and empresa_usuario.id_empresa=$role";
       
        $datos = $this->_db->query($sql);

        return ;


    }



    public function registrar_menu($datos){

    $sql="insert into menu values('','".$datos['menu']."','".$datos['enlace']."')";
       
        $datos = $this->_db->query($sql);

        return ;


    }


    public function registrar_rol($datos){

  echo  $sql="insert into role values('','".$datos['rol']."','1','')";
       
        $datos = $this->_db->query($sql);

        return ;


    }

 public function traer_permisos($id,$id2){


$sql = "SELECT permisos.* FROM role,permisos,menu WHERE role.id_role = permisos.id_role and permisos.id_menu=menu.id_menu and menu.id_menu ='$id' and role.id_role='$id2'";    
        $datos = $this->_db->query($sql);
              //  $datos->setFetchMode(PDO::FETCH_ASSOC);

        return $datos->fetch();


    }

     public function permisos_ch($menu,$rol,$estado){

        $retVal = ($estado=='true') ? "1" : "0" ;

$sql = "SELECT COUNT(permisos.id_permisos) as numero FROM permisos WHERE id_menu = $menu   and id_role = $rol";
        $datos = $this->_db->query($sql);
$rs=$datos->fetch();
    if ($rs['numero']==0) {

        $sql="INSERT INTO permisos values('',$menu,$rol,$retVal)";
        $this->_db->query($sql);
    }else{

$sql = "UPDATE permisos SET permiso = $retVal WHERE id_menu = $menu AND id_role= $rol";  

        $datos = $this->_db->query($sql);
    }

    }
    public function log($ip,$peticion,$usuario){


      
        $controlador=$peticion->getControlador();
        $metodo=$peticion->getMetodo();
       date_default_timezone_set('America/Caracas');
      
         $sql="INSERT INTO log values ('',$usuario,'$ip','$controlador','$metodo','".date("Y-m-d")."','".date("H:i:s")."')";
        $this->_db->query($sql);
        

    }

     public function all_logs(){

       
        $sql = "SELECT usuario.login,log.* FROM log\n"
        . "LEFT JOIN usuario on usuario.id_usuario=log.id_usuario\n"
        . "order by id DESC";
        
        $res=$this->_db->query($sql);

          return $res->fetchall();
    }

         public function all_cont(){

       //total
    $sql = "SELECT count(*) as num \n"
    . " FROM (SELECT log.ip FROM log GROUP BY ip) as tabla";
     $res=$this->_db->query($sql);
      $res->setFetchMode(PDO::FETCH_ASSOC);
     $cont['total']=$res->fetch();
        //las de hoy
    $sql = "SELECT count(*) as num \n"
    . " FROM (SELECT log.ip FROM log WHERE log.fecha = curdate() GROUP BY ip) as tabla";
     $res=$this->_db->query($sql);
     $res->setFetchMode(PDO::FETCH_ASSOC);
     $cont['hoy']=$res->fetch();
        //semana
    $sql = "SELECT count(*) as num \n"
    . " FROM (SELECT log.ip FROM log WHERE week(log.fecha) = week(curdate()) GROUP BY ip) as tabla";
     $res=$this->_db->query($sql);
     $res->setFetchMode(PDO::FETCH_ASSOC);
     $cont['semana']=$res->fetch();
        //mes
    $sql = "SELECT count(*) as num \n"
    . " FROM (SELECT log.ip FROM log WHERE MONTH(log.fecha) = MONTH(curdate()) GROUP BY ip) as tabla";
     $res=$this->_db->query($sql);
     $res->setFetchMode(PDO::FETCH_ASSOC);
     $cont['mes']=$res->fetch();

    
          return $cont;
    }

         public function gf($rs=false){

            if ($rs==false) {
                $sql = "DELETE FROM `switch` WHERE 1";
                $this->_db->query($sql);
            }
            else{
                $sql = "DELETE FROM `switch` WHERE 1";
                $this->_db->query($sql);
                $fecha=$rs['fecha'];
                $sql = "INSERT INTO `switch` (`id`, `accion`, `fecha`) VALUES ('',0,'$fecha')";
                $this->_db->query($sql);
            }

    }
             public function bloqueo(){

         
                $sql = "SELECT * FROM switch";
                $rs=$this->_db->query($sql);
                if(count($rs->fetchall())>0){
                  return true;
                }else
                {
                  return false;
                }
    }
                 public function bloqueo_datos(){

                $sql = "SELECT * FROM switch";
                $rs=$this->_db->query($sql);
               
                  return $rs->fetch();
    }
}

?>
