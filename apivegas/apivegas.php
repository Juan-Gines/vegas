
  <?php
    require "Conexion.php";    
    header('Content-Type:application/json; charset=UTF-8');
      
    $conexion=new Conexion();
    if($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_GET["registro"])){
      $final=$conexion->post();
    }elseif(isset($_GET["existe"])){
      $final=$conexion->existe();
    }elseif ($conexion->login()) {
      switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
          if (isset($_GET["login"])) {
              $final=$conexion->logOK();
          } elseif (isset($_GET["id"])) {            
              $final=$conexion->getID();
          } 
          break;
        case "DELETE":
          $final=$conexion->delete();
          break;
        case "POST":
          $final=$conexion->post();
          break;
        case "PUT":
          $final=$conexion->put();
        }
        if (isset($final["error"])) {
          http_response_code(400);
        }        
    }
    $conexion->close();
    $final=json_encode($final);
    echo $final;