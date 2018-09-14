<?php

class layoutModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
   public function cargar_menu(){

    $datos = $this->_db->query( 
                "
select *, if(id_menu_fk is null,1,0)as vn, if(a.id_menu=(select id_menu_fk from menu where id_menu_fk=a.id_menu group by id_menu_fk),1,0) as padre  from menu as a"
                );
        
        return $datos->fetchall();


   }

   public function cargar_sub_menu($id){


$datos = $this->_db->query( 
                "select * from menu where id_menu_fk = '$id'"
                );
        
        return $datos->fetchall();

   }
}

?>
