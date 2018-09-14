<?php

class recuperarController extends Controller
{
    public $_recuperar;
    public $_usuario;
    
    public function __construct(){
        parent::__construct();
        $this->_recuperar = $this->loadModel('recuperar');
    }
    
   
   public function index()
    {

        if(Session::get('autenticado')):
            $this->_view->usu=$this->_recuperar->traerid_enc(Session::get('id_usuario'));
            else:
            $this->_view->usu=0;
            endif;
            $this->_view->area_l="apagada";
        
        $this->_view->titulo = 'Recuperar Cuenta - OrienteX';
        $this->_view->setJs(array('recuperar'));
        
       $this->_view->renderizar('index');

    }

    public function cambiar(){
        $this->_view->area_l="apagada";
		 
          $this->_view->titulo = 'Cambiar Contraseña';
         $this->_view->setJs(array('recuperar'));

		 
		
        

       
         $this->_view->renderizar('cambiar');
   
    } 
   
   public function recuperarcuenta(){


    echo json_encode($this->_recuperar->traer_infousuario($_POST['correo']));


   }

   public function cambiarclave(){


    $this->_recuperar->cambiar_clave($_POST['actual'],$_POST['nueva'],session::get('id_usuario'));


   }
 public function actualizarclave(){





    $this->_recuperar->actualizar_clave($_POST['nueva'],$_POST['login']);


   }

    public function buscarusuario(){

 
echo json_encode($this->_recuperar->buscar_usuario($_POST['actual'],session::get('usuario')));  


   }
   

   public function enviaremail(){



     $this->getLibrary('class.phpmailer');
            
            $mail = new PHPMailer();
            $mail->IsSMTP(); 
            $mail->SMTPDebug  = 1;                   
            $mail->SMTPAuth   = true; 
            $mail->SMTPSecure = "tls";               
            $mail->Host       = "smtp.gmail.com";
            //
            $mail->Username   = "prccnoreply@gmail.com";       
            $mail->Password   = "20574205";        
            $mail->SetFrom('prccnoreply@gmail.com');
            
            $mail->AddReplyTo("prccnoreply@gmail.com","prcc");    
            $mail->Subject = 'Recuperacion de cuenta de usuario';
            $mail->Body = 'Hola ' . $_POST['login'] . ',' .
                            'ha solicitado recuperar su cuenta en www.prcc.no-ip.info/mvc su clave ' .
                            'es la siguiente:' . $_POST['clave'];

            $mail->AddAddress($_POST['email']);
            
            $mail->Send();            
       
       
            

            
            
            
    
            
             
        
            $this->_view->datos = false;
            $this->_view->_mensaje = 'Registro Completado, revise su email para activar su cuenta';






   }
}

?>
