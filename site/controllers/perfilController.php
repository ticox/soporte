<?php


class perfilController extends Controller
{
	
	private $_nina;
    public function __construct() {
        parent::__construct();
  	 $this->_index=$this->loadModel('principal');	
      
    }

    public function index(){
        $this->_view->titulo ="OrienteX";
        $this->_view->setJs(array('index'));
        $this->_view->setCss(array('css2'));
        $this->_view->renderizar('perfil');
    }


    function buscar_chicas(){
        $this->chicas=$this->loadModel('principal');
       echo json_encode( $this->chicas->buscar_chicas($_POST['nombre_chica']));
    }

    /*public function individual($id)
    {

        if($id==false){

            $this->redireccionar('principal');

        } 
  
			
			$this->_view->setJs(array('index'));
			$this->_view->setCss(array('css2'));

			$rs=$this->_index->get_all();

        	for ($i=0; $i < count($rs) ; $i++) { 
        		
        		if($rs[$i]["id_chicas"]==$id):

        			$index=$i;

        		$rs[$i]["fotos"]=$this->_index->get_photo_all($rs[$i]["id_chicas"]);
        		$this->_view->titulo = $rs[$i]['nombre_chicas']." - OrienteX";

        		endif;



        	}


        	$this->_view->datos=$rs[$index];
            $this->_view->valoracion=$this->_index->promedio_chica($id);
        	
			$this->_view->renderizar('index');
							
			
	}*/

   
}

?>