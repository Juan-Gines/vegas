<?php
  session_start();
  require_once "controladores/inicio.php";
  /* echo "<pre>";
  var_dump($_SESSION); 
  echo "</pre>"; */ 
  if(isset($_GET["registro"])||$_SESSION["registro"]){
    $form->registro();
  }elseif (!$_SESSION["login"]&&!$_SESSION["ban"]) {
    $form->login();
  }elseif($_SESSION["ban"]){
    $vista->ban();
  }else{
    if($_SERVER["REQUEST_METHOD"]=="GET"){    
      switch (true) {
        case empty($_GET):
          $home->home();
          break;
        case isset($_GET["ruleta"]):
          $ruleta->ruleta();
          break;
        case isset($_GET["blackjack"]):
          $blackjack->blackjack();
          break;
        case isset($_GET["close"]):
          $form->close();
        case isset($_GET["volver"]):
          $form->volver();
        default:
          
          $vista->ban();
          break;
      }
    }elseif($_SERVER["REQUEST_METHOD"]=="POST"){
      switch (true){
        case isset($_GET["ruleta"]):          
          $ruleta->ruleta();
      }
    }
  }
