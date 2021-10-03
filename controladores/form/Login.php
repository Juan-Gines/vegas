<?php
require_once "modelo/Servicios.php";
class Login {
	private $query;

  function __construct(){
    $this->query=new Servicios();
  }
  function login($email, $pass) {		
		$resultado=$this->query->login($email, $pass);      
    if (isset($resultado["login"])) {       
        $er_login="<p>logueaste con éxito</p>";
        $_SESSION["login"]=true;
        $_SESSION["contador"]=5;
        $_SESSION["user"]=$resultado;            
    } else {
        $er_login=$this->intentos();
    }     
    return $er_login;
  }
  private function intentos(){
      $_SESSION["contador"]--;
      if ($_SESSION["contador"]>0) {
          $er_login=" * Usuario desconocido, resta".(($_SESSION["contador"]==1)?" ":"n ")."{$_SESSION["contador"]} intento".(($_SESSION["contador"]==1)?"":"s").".";
      } else {          
          $_SESSION["ban"]=true;
          header('Location:'.$_SERVER["PHP_SELF"]);
      }
      return $er_login;
  }
}