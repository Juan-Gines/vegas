<?php
  require_once "vistas/Vistas.php";
  class Salon{    
    private $vista;

    public function __construct() {
      
      
      $this->vista=new Vistas;
    }

    public function home(){
      $this->vista->salon();
    }    
  }