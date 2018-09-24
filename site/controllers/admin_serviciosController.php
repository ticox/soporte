<?php


class admin_serviciosController extends Controller
{
	
	private $_index;
    public function __construct() {
        parent::__construct();
          $this->getLibrary('simpleimage');
  	 $this->_index=$this->loadModel('admin_servicios');	
      
    }

    public function index()
    {


			
			$this->_view->setJs(array('principal'));
			$this->_view->setCss(array('css','style'));
        	$this->_view->titulo = 'Pedido/Servicio - COTEDEM';

        	$servicios=$this->_index->buscar_servicios_admin();
            $servicio_r=$this->_index->buscar_servicios_admin_solucionados();
        	
        	$this->_view->servicio_r=$servicio_r;
            $this->_view->servicio=$servicios;
			$this->_view->renderizar('index');

							
			
	}

	function registrar_servicio(){
       $this->_index->registrar_servicio($_POST);
    }


    function buscar_servicio_usuario(){
       echo json_encode( $this->_index->buscar_servicio_usuario($_POST['servicio']));
    }


    function buscar_servicios_solucionados(){
       echo json_encode( $this->_index->buscar_servicios_solucionados($_POST['usuario']));
    }


    function cambiar_estatus_servicio(){
       $this->_index->cambiar_estatus_servicio($_POST,$_FILES);

       $this->redireccionar('admin_servicios');

        $this->getLibrary('class.phpmailer');
            
            $email_user = "info@cotedem.com";
            $email_password = "Cotedem@2018";
            $asunto = "Respuesta a su solicitud de soporte";
            $nombre = $_POST['nombre'];
            $mensaje = $_POST['observacion'];
            $correo = $_POST['correo'];
            $pedido = $_POST['pedido'];

            $phpmailer = new PHPMailer();

            // ---------- Datos de la cuenta de correo -----------------------------
            $phpmailer->Username = $email_user;
            $phpmailer->Password = $email_password; 
            //---------------------------------------------------------------------
            $phpmailer->SMTPSecure = 'ssl';
            $phpmailer->Host = "box308.bluehost.com";
            $phpmailer->Port = 465;
            //$phpmailer->SMTPDebug = 2;
            $phpmailer->IsSMTP();
            $phpmailer->SMTPAuth = true;

            $phpmailer->setFrom($phpmailer->Username,$nombre);
            $phpmailer->AddAddress($correo);
            $phpmailer->Subject =$asunto; 

            $phpmailer->Body .="<h3 style='color:#000;'>Saludos ".$nombre."</h3>";
            $phpmailer->Body .= "<h3>Su solicitud de soporte, fue <i style='color:green;'> <b> Solucionado</b> </i>.</h3><br>";
            $phpmailer->Body .="<br> <h4> <b> Observacion/Solucion:</b></h4> <p>".$mensaje." </p>  <br> Sin mas que agregar, se Despide el equipo de soporte de Cotedem.";

            $phpmailer->AddAttachment($mensaje, "attach1");
            $phpmailer->AddBCC($correo, "bcc1");
            $phpmailer->IsHTML(true);
            $enviado = $phpmailer->Send();
            if($enviado) {
                echo 'Email Enviado Exiosamente';
            }





    }



	function buscar_servicio_solucionado(){
       echo json_encode( $this->_index->buscar_servicio_solucionado($_POST['servicio']));
    }

	
}


?>