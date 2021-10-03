<?php
  require_once "modelo/Servicios.php";
  require_once "controladores/juegos/Ruleta.php";
  class juegos{
    private $entrada;

    public function __construct(){

      $this->entrada=new Servicios();
    }

    public function resultado($datos){
      $consulta["tabla_prin"]="usuarios";
      $consulta["cond_ig"]["usu_id"]=$_SESSION["user"]["usu_id"];      
      $consulta["usu_puntos"]=$datos;      
      $setPuntos=$this->entrada->put($consulta);     
    }   
  }