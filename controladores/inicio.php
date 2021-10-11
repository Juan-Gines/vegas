<?php
  require_once "vistas/Vistas.php";
  require_once "controladores/form/Formularios.php";
  require_once "controladores/juegos/Ruleta.php";  
  require_once "controladores/juegos/blackjack.php";  
  $vista=new Vistas;
  $form=new Formularios;
  $home=new Salon;
  $ruleta=new Ruleta;
  $blackjack=new Blackjack;
    if(!isset($_SESSION["login"])){
      $_SESSION["login"]=false;
      $_SESSION["registro"]=false;
      $_SESSION["ban"]=false;
      $_SESSION["contador"]=5;
      $_SESSION["user"]=[];
    }