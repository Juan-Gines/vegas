<?php
  header('Content-Type:application/json; charset=UTF-8');
  require_once "../librerias/ValidarInputs.php";
  require_once "../librerias/Querys.php";    
  class Conexion {       
            
    private $dblink;
    private $log;
    private $user;    
    private $query;

    //funciones conexion
    function __construct(){
      require_once "../config/config.php";
      $this->dblink=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
      if(mysqli_connect_errno()){
        http_response_code(501);
        $error=["error"=>"Conectandose a la base de datos. Contacte con el administrador."];
        $error=json_encode($error);
        die ($error);
      }
      
      $this->dblink->set_charset("utf8mb4");      
      $this->query=new Querys();         
    }
    
    public function close(){      
      $this->dblink->close();
    }

    //función de autentificación
    public function login(){            
      $this->log=false; 
      if (!empty($_GET["email"])&&!empty($_GET["pass"])) {
				$limpio=Validarinputs::limpio_sql($this->dblink, ["email_limp"=>$_GET["email"], "pass_limp"=>$_GET["pass"]]);        
				$query="SELECT * FROM usuarios WHERE usu_email='{$limpio["email_limp"]}'";
        $resultado=$this->dblink->query($query);				
				if ($resultado->num_rows==1) {
          $pass=$resultado->fetch_assoc();                     
          if (password_verify($limpio["pass_limp"], $pass["usu_password"])) {
            $this->log=$pass["usu_id"];
            $pass['usu_password']=$limpio["pass_limp"];
            $this->user=$pass;
          }
				}      
      }
      $resultado->free_result();              
      return $this->log;            
    }
    public function logOK(){     
      if(isset($_GET["login"])){        
        $resultado=$this->user;
				$resultado["login"]=true;
      }            
      return $resultado;
    }

    //función que busca un registro

    public function existe(){     
      unset($_GET["existe"]);      
      $limpio=Validarinputs::limpio_sql($this->dblink,$_GET);
      $query=Querys::select($limpio);      
      $result=$this->dblink->query($query);
      if ($result->num_rows==1) {
        $resultado=$result->fetch_assoc();
        $result->free_result();
      } else {
        $resultado=["error"=>"Recurso no encontrado"];
      }       
      return $resultado;
    }
    
    public function getID(){
      unset($_GET["user"]);
      unset($_GET["pass"]);
      unset($_GET["id"]);
      $limpio=Validarinputs::limpio_sql($this->dblink,$_GET);
      $query=Querys::select($limpio);            
      $result=$this->dblink->query($query);
      if ($result->num_rows==1) {
        $resultado=$result->fetch_assoc();
        $result->free_result();
      } else {
        $resultado=["error"=>"Recurso no encontrado"];
      }       
      return $resultado;
    }
    public function delete(){      
      if (isset($_GET["id"])) {
				$id_limp=Validarinputs::limpio_sql($this->dblink,$_GET["id"]);
				if (is_numeric($id_limp)) {
          $query="DELETE FROM favoritos  WHERE id_per={$this->log} AND id_fav={$id_limp}";
          $this->dblink->query($query);
          if ($this->dblink->affected_rows==1) {
              $resultado=["borra"=>"Registro borrado"];
          } else {
              $resultado=["error"=>"El registro no se ha borrado"];
          } 
				}
      }      
      return $resultado;
    }
    public function post(){      
      $strjs=file_get_contents("php://input");      
      $post=json_decode($strjs,true);          
      $post=Validarinputs::limpio_sql($this->dblink,$post);                    
      $query=Querys::post($post);                        
      $this->dblink->query($query);
      if ($this->dblink->affected_rows==1) {
				$resultado=["bueno"=>"Usuario insertado correctamente"];
      } else {
				$resultado=["malo"=>"No se inserto el usuario"];
      }      
      return $resultado;
    }
    public function put(){      
      $strjs=file_get_contents("php://input");
      $put=json_decode($strjs,true);
      $putlimpio=Validarinputs::limpio_sql($this->dblink,$put);
      $query=Querys::put($putlimpio);
      $this->dblink->query($query);
      if ($this->dblink->affected_rows==1) {
				$resultado=["bueno"=>"Favorito modificado correctamente"];
      } else {
				$resultado=["malo"=>"No se modificó el favorito"];
      }      
      return $resultado;
    }
  }