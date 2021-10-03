<?php
  
  require_once "librerias/Contexto.php";
  require_once "config/config.php";

  class Servicios{    
    private $url;

    public function __construct() {      
      $this->url=URLSERVER;
    }

    function login($email,$pass){                             
      $resultado=file_get_contents($this->url."?email={$email}&pass={$pass}&login",false,Contexto::contexto('get'));      
      $result=json_decode($resultado,true);
      /* echo "<pre>";
      var_dump($result);
      echo "</pre>"; */            
      return $result;
    }

    function existe($datos){      
      $datosurl=http_build_query($datos);      
      $resultado=file_get_contents($this->url."?".$datosurl."&existe",false,Contexto::contexto('get'));      
      $result=json_decode($resultado,true);                 
      return $result;
    }

    function registro($tabla,$datos){
      $datos["tabla"]=$tabla;
      unset($datos["pass2"]);     
      $resultado=file_get_contents($this->url."?registro",false,Contexto::contexto('post',$datos));      
      $result=json_decode($resultado,true);              
      return $result;
    }
    
    function post($tabla,$datos){
      $datos["tabla"]=$tabla;     
      $resultado=file_get_contents($this->url."?registro",false,Contexto::contexto('post',$datos));      
      $result=json_decode($resultado,true);              
      return $result;
    }
    function put($datos){
      $url["email"]=$_SESSION["user"]["usu_email"];
      $url["pass"]=$_SESSION["user"]["usu_password"];           
      $datosurl=http_build_query($url);           
      $resultado=file_get_contents($this->url."?".$datosurl,false,Contexto::contexto('put',$datos));       
      $result=json_decode($resultado,true);                 
      return $result;
    }
  }