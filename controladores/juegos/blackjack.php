<?php
  require_once "modelo/Servicios.php";
  require_once "vistas/Vistas.php";
  require_once "librerias/ValidarInputs.php";
  require_once "controladores/juegos/Juegos.php";
  class Blackjack extends Juegos{
    
    private $vista;
    private $datos;
    function __construct() {
      parent::__construct();
      $this->vista=new Vistas();
      $this->datos=[];
    }    
    function blackjack(){      
      if($_SERVER["REQUEST_METHOD"]=="POST"&&$_POST["idrand"]==$_SESSION["idrand"]){
        if(isset($_POST["black"])){
          $validador=["rojo","negro","par","impar","falta","pasa"];
          $validador=array_merge($validador,array_keys($numeros));          
          ValidarInputs::limpio_select($_POST["apuesta"],$validador);
          (ValidarInputs::valido())?$this->datos["apuesta"]=$_POST["apuesta"]: $this->datos["pantalla"]="Datos erroneos";
          ValidarInputs::limpio_select($_POST["dinero"],["5","10","20","50","100"]);
          (ValidarInputs::valido())?$this->datos["dinero"]=$_POST["dinero"]: $this->datos["pantalla"]="Datos erroneos";                  
          if(isset($this->datos["apuesta"]) &&isset($this->datos["dinero"])){
            $_SESSION["user"]["usu_puntos"]-=$this->datos["dinero"];                        
            $sorteo=mt_rand(0,36);
            $resultado=$numeros[$sorteo];
            $resultado[]=$sorteo;              
            if (in_array($this->datos["apuesta"], $resultado)) {
              if (is_numeric($this->datos["apuesta"])) {
                $ganancias=$this->datos["dinero"]*35;
                $_SESSION["user"]["usu_puntos"]+=$ganancias;
              } else {
                $ganancias=$this->datos["dinero"]*2;
                $_SESSION["user"]["usu_puntos"]+=$ganancias;
              }
            }
            $this->datos["resultado"]=$sorteo." ";
            $this->datos["resultado"].=(count($resultado)==2)?" Banca":" ".$resultado[0]." ".$resultado[1]." y ".$resultado[2];
            $this->datos["pantalla"]=(isset($ganancias))? "Ganaste {$ganancias}€ ":"Perdiste {$this->datos["dinero"]}€ ";
            $this->datos["win"]=(isset($ganancias))?true:false;
            $this->resultado($_SESSION["user"]["usu_puntos"]);
          }
          
        }
      }
      $this->vista->ruleta($this->datos);
    }
  }