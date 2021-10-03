<?php
require_once "controladores/form/Login.php";
require_once "controladores/form/Registro.php";
require_once "librerias/validarInputs.php";
  class Formularios {   
    private $vista;
    private $datos=[];
    private $log;
    private $reg;   

    function __construct(){      
      $this->vista=new Vistas();
      $this->log=new Login();
      $this->reg=new Registro();
    }

    function login(){            
      if (isset($_POST["login"])&&$_SESSION["idrand"]==$_POST["idrand"]) {        
        ValidarInputs::limpio_email($_POST["email"]);
        (ValidarInputs::valido())? $this->datos["email"]=ValidarInputs::msj() : $this->datos["er_email"]=ValidarInputs::msj();
        ValidarInputs::limpio_pass($_POST["pass"]);
        (ValidarInputs::valido())? $this->datos["pass"]=ValidarInputs::msj() : $this->datos["er_pass"]=ValidarInputs::msj();			
        if (empty($this->datos["er_email"])&&empty($this->datos["er_pass"])) {          
          $this->datos["pantalla"]=$this->log->login($this->datos["email"],$this->datos["pass"]);
          if ($_SESSION["login"]) {
              header('Location:'.$_SERVER["PHP_SELF"]);
              exit;
          }         
        }else{
          $this->datos["pantalla"]=(isset($this->datos["er_email"]))?" * ".$this->datos["er_email"]:"";
          $this->datos["pantalla"].=(isset($this->datos["er_pass"]))?" * ".$this->datos["er_pass"]:"";
        }
      }
      $this->vista->login($this->datos);
    }

    function registro(){           
      if (isset($_POST["registro"])&&$_SESSION["idrand"]==$_POST["idrand"]) {        
        ValidarInputs::limpio_email($_POST["email"]);
        (ValidarInputs::valido())? $this->datos["usu_email"]=ValidarInputs::msj() : $this->datos["er_email"]=ValidarInputs::msj();
        $pass=ValidarInputs::limpio_pass($_POST["pass"]);        
        (ValidarInputs::valido())? $pass["msj"]=$this->datos["usu_password"]=ValidarInputs::msj() : $pass["msj"]=$this->datos["er_pass"]=ValidarInputs::msj();
        ValidarInputs::limpio_pass2($pass,$_POST["pass2"]);
        (ValidarInputs::valido())? $this->datos["pass2"]=ValidarInputs::msj() : $this->datos["er_pass2"]=ValidarInputs::msj();
        ValidarInputs::limpio_alfanum($_POST["nick"],"Nick");
        (ValidarInputs::valido())? $this->datos["usu_nick"]=ValidarInputs::msj() : $this->datos["er_nick"]=ValidarInputs::msj();
        ValidarInputs::limpio_fecha($_POST["fnac"]);
        (ValidarInputs::valido())? $this->datos["usu_fnacimiento"]=ValidarInputs::msj() : $this->datos["er_fnac"]=ValidarInputs::msj();             
        if (empty($this->datos["er_email"])&&empty($this->datos["er_pass"])&&empty($this->datos["er_pass2"])&&empty($this->datos["er_nick"])&&empty($this->datos["er_fnac"])) {
          $resultado=$this->reg->registro($this->datos);
          if (($resultado["er_reg"])) {
            $_SESSION["registro"]=false;
            header('Location:'.$_SERVER["PHP_SELF"]);
            exit;
          }else{
            $this->datos["er_nick"]=isset($resultado["er_nick"])?$resultado["er_nick"]:"";
            $this->datos["er_email"]=isset($resultado["er_email"])?$resultado["er_email"]:"";
          }
        }
      }elseif(isset($_POST["inicio"])){
        session_destroy();
        header('Location:'.$_SERVER["PHP_SELF"]);
        exit;    
      }
        $this->vista->registro($this->datos);
        $_SESSION["registro"]=true;            
    }
    function volver(){
      ($_SESSION["ruleta"])?$_SESSION["ruleta"]=false:header('Location:'.$_SERVER["PHP_SELF"]);      
      exit;
    } 
    function close(){
      session_destroy();
      header('Location:'.$_SERVER["PHP_SELF"]);
      exit;
    }    
  }