<?php


class appController extends Controller
{
	
	private $app;
	
	
    public function __construct() {

        Session::acceso();

        parent::__construct();
      $this->app=$this->loadModel('app');
		
    }

    public function index()
    {

            if(!Session::get('autenticado')){
            $this->redireccionar('login');
        }
			$this->_view->setJs(array('js','jscolor'));
			$this->_view->setCss(array('css'));
        	$this->_view->titulo = 'menus';

        	$menu=$this->app->traer_menus();
        	$role=$this->app->traer_roles();
        	$matris = Array();
        	for ($i=0; $i < count($menu) ; $i++) { 

        		for ($y=0; $y < count($role); $y++) { 

        					$vn=$this->app->traer_permisos($menu[$i]['id_menu'],$role[$y]['id_role']);
        	        		if ($vn=='') {
        	        			$matris[$i][$y]['permiso']='0';
        	        		}else{
        	        		$matris[$i][$y]=$this->app->traer_permisos($menu[$i]['id_menu'],$role[$y]['id_role']);
	
        	        		}
        	        		
        	        		}
        		
        		

        	

        	}




             $this->_view->bloqueo=$this->app->bloqueo();
            $this->_view->bloqueo_datos=$this->app->bloqueo_datos();
        	$this->_view->cont=$this->app->all_cont();
            $this->_view->logs=$this->app->all_logs();
        	$this->_view->menus=$menu;
			$this->_view->rol=$role;
			$this->_view->matris=$matris;
			$this->_view->renderizar('index');		
	}


    function verificar_login(){
       echo json_encode( $this->app->verificar_login($_POST['usuario']));
    }


     function buscar_roles(){
       echo json_encode( $this->app->traer_roles());
    }
function buscar_empresas_usuario(){
       echo json_encode( $this->app->buscar_empresas_usuario($_POST['usuario']));
    }


    function eliminar_usuario(){
        $this->app->eliminar_usuario($_POST['usuario']);
    }


    function asignar_empresa_usuario(){
       $this->app->asignar_empresa_usuario($_POST['usuario'],$_POST['role']);
    }

    function eliminar_empresa_usuario(){
       $this->app->eliminar_empresa_usuario($_POST['usuario'],$_POST['role']);
    }



    function permisos_ch(){


        $this->app->permisos_ch($_GET['menu'],$_GET['rol'],$_GET['estado']);

    }

function registrar_menu(){
        $this->app->registrar_menu($_POST);
    }

    function registrar_rol(){
        $this->app->registrar_rol($_POST);
    }

   public function guardar_usuario(){


        $this->app->guardar_usuario($_POST);


   }


   function buscar_usuario(){
       echo json_encode( $this->app->buscar_usuario($_POST['usuario']));
    }


      function editar_usuario(){

       echo json_encode($this->app->editar_usuario($_POST['id_usuario']));
    }


    function modificar_usuario(){

       $this->app->modificar_usuario($_POST);
    }


    
    function updonw(){
     $objeto=$this->loadModel('app');
       echo print_r($_POST);
       if ($_POST['accion']==0) {
            $objeto->gf($_POST);
       }else{
            $objeto->gf();
       }
    }
}


?>