<?php

class loginModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getUsuario($usuario, $password, $empresa)
    {

         $sql="SELECT DISTINCT usuario.*, role.nombre_role, role.id_role from usuario, empresa_usuario, role where usuario.id_usuario=empresa_usuario.id_usuario and role.id_role='".$empresa."' and usuario.id_usuario=(SELECT id_usuario from usuario where login='".$usuario."' and password= '" . Hash::getHash('sha1', $password, HASH_KEY)."')";

          $datos = $this->_db->query($sql);
        
          return $datos->fetch();
    }




 public function verificar_user($datos){
   
         $sql="SELECT usuario.*, role.* from usuario, empresa_usuario, role where usuario.id_usuario=empresa_usuario.id_usuario and role.id_role=empresa_usuario.id_empresa and usuario.id_usuario=(SELECT id_usuario from usuario where login='".$datos['usuario']."' and password= '" . Hash::getHash('sha1', $datos['clave'], HASH_KEY)."')";
        $rs = $this->_db->query($sql);
        $res=$rs->fetchall();

       $reg=count($res);
      if ($reg<='0'){
        $res=0;
        return $res;
      }else{
        return $res;
      }
        

   }
}
?>
