<?php
require_once "modelo/Servicios.php";
class Registro{
	private $query;

  function __construct(){
    $this->query=new Servicios();
  }
  function registro($datos) {
    $datos["usu_password"]=password_hash($datos["usu_password"],PASSWORD_DEFAULT);
    $busqueda["cond_ig"]=["usu_email"=>$datos["usu_email"]];
    $busqueda["tabla_prin"]="usuarios";
    $busqueda["usu_id"]="";
    $busqueda2["cond_ig"]=["usu_nick"=>$datos["usu_nick"]];
    $busqueda2["tabla_prin"]="usuarios";
    $busqueda2["usu_id"]="";    
    $existe_email=$this->query->existe($busqueda);
    $existe_nick=$this->query->existe($busqueda2);    
    $registro["er_reg"]=false;
    if(isset($existe_email["usu_id"])){
      $registro["er_email"]="<small>Email usado</small>";
    }
    if(isset($existe_nick["usu_id"])){
      $registro["er_nick"]="<small>Nick usado</small>";
    }
    if (!isset($existe_email["usu_id"])&&!isset($existe_nick["usu_id"])) {
      $registro["er_reg"]=$this->query->registro("usuarios", $datos);
      $registro["er_reg"]=isset($registro["er_reg"]["bueno"])?true:false;
    }
    return $registro;
  }  
}