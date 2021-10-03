<?php

class ValidarInputs{
  //campos de retorno de validación
  private static $valido;
  private static $msj;
  //Array con las letras del dni ordenadas
  private $letra_dni = [
              'T','R','W','A','G','M','Y','F','P','D','X','B',
              'N','J','Z','S','Q','V','H','L','C','K','E'];
  //Funciones de limpieza y validación de inputs
  //Funcion que recibe un str y lo devuelve sin espacios de más sin barras de escape ni caracteres html
  private static function input_test($input){
    $input=trim($input);
    $input=stripslashes($input);
    $input=htmlspecialchars($input);
    return $input;
  }
  //Función que valida un input mail si viene vacio o con caracteres basura
  public static function limpio_email($mail){
    if (empty($mail)) {
      self::$msj= "<small>Email requerido</small>";
      self::$valido=false;
    } else {
      $mail=self::input_test($mail);            
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
          self::$msj= "<small>Mail inválido</small>";
          self::$valido=false;
        } else {
          self::$msj=$mail;
          self::$valido=true;
        }
    }           
  }
  //Función que valida un input text si viene vacio o con caracteres basura
  public static function limpio_alfanum($alfanum,$campo,$max=50,$min=1){
    if (empty($alfanum)) {
      self::$msj= "<small>". $campo . " requerido</small>";
      self::$valido=false;
    } else {            
      $alfanum=self::input_test($alfanum);                       
        if (!preg_match("/^[Á-ÚÀ-ÙÄËÏÖÜá-úà-ùä-ü\w\d '-]{" . $min . "," . $max . "}$/i",$alfanum)) {
          self::$msj= "<small>Sólo alfanúmericos " . $min . "-" . $max . "</small>";
          self::$valido=false;
        } else {
          self::$msj=$alfanum;
          self::$valido=true;
        }
    }                    
  }
  //Funcion que valida un input DNI si viene vacío o es incorrecto
  public static function limpio_dni($dni){        
    if (empty($dni)) {
      self::$msj= "<small>Dni requerido</small>";
      self::$valido=false;
    } else {            
      $dni=self::input_test($dni);                           
      if (!preg_match("/^[\d]{8}[A-Z]{1}$/i",$dni)||self::$letra_dni[intval(substr($dni,0,8))%23]!=strtoupper(substr($dni,8,1))) {
          self::$msj= "<small>DNI/NIF invalido!</small>";
          self::$valido=false;
        } else {
            $dni=strtoupper($dni);                
          self::$msj=$dni;
          self::$valido=true;
        }
    }                  
  }

  public static function limpio_pass($pass){
    if(empty($pass)){ 
      self::$msj= "<small>Password requerido</small>";
      self::$valido=false;         
    }else{
      self::$msj=htmlspecialchars($pass);
      self::$valido=true;
    }
    $resultado=["valido"=>self::$valido,"msj"=>self::$msj];
    return $resultado;           
  }

  public static function limpio_pass2($pass1,$pass){        
    if (empty($pass)) {
      self::$msj= "<small>Password requerido</small>";
      self::$valido=false;
    } else {
      $pass=htmlspecialchars($pass);
      if ($pass1["valido"]&&$pass1["msj"]==$pass) {
        self::$msj=$pass;
        self::$valido=true;
      } else {                
        self::$msj= "<small>Password diferente</small>";
        self::$valido=false;
      }
    }               
  }

  public static function limpio_fecha($fecha){
    if (empty($fecha)) {
      self::$msj= "<small>Fecha requerida</small>";
      self::$valido=false;
    } else {
    $fecha=self::Input_test($fecha);
      if (!preg_match("#^[\d]{4}(-)[\d]{2}(-)[\d]{2}$#", $fecha)) {
        self::$msj= "<small>Fecha invalida!</small>";
        self::$valido=false;
      } else {
        $f=explode("-", $fecha);
        if (!checkdate($f[1], $f[2], $f[0])) {
          self::$msj= "<small>Fecha invalida!</small>";
          self::$valido=false;
        } else {
          $fecha=date_create($fecha);
          $fecha_actual=date_create();
          $diff=date_diff($fecha, $fecha_actual);                    
          if ($diff->format('%y')<10||$diff->invert==1) {
            self::$msj= "<small>Fecha invalida!</small>";
            self::$valido=false;
          } else {
            self::$msj=date_format($fecha,'Y-m-d');
            self::$valido=true;
          }
        }
      }
    }            
  }
  public static function limpio_url($url){
      if(empty($url)){ 
        self::$msj= "<small>Por favor rellena la url</small>";
        self::$valido=false;         
      }else{
        $url=self::input_test($url);            
          if (!filter_var($url, FILTER_VALIDATE_URL)) {
            self::$msj= "<small>Introduzca una url válida</small>";
            self::$valido=false;
          } else {
            self::$msj=$url;
            self::$valido=true;
          }
      }            
  }        
  public static function limpio_sql($dblink,$input){
    foreach($input as $key=>$limpio){                
      if(is_array($limpio)){
        foreach ($limpio as $k=>$lim) {
            $lim=htmlspecialchars($lim);
            $lim=mysqli_real_escape_string($dblink,$lim);
            $input[$key][$k]=$lim;                        
        }
        continue;
      }
      $limpio=htmlspecialchars($limpio);
      $limpio=mysqli_real_escape_string($dblink,$limpio);
      $input[$key]=$limpio;
    }
    return $input;
  }

  public static function limpio_select($select,$options){
    foreach($options as $opc){
      self::$valido=($opc==$select)?true:false;
      self::$msj=(self::$valido)?"":"Dato incorrecto";
      if(self::$valido){
        break;          
      }else{
        continue;
      }
    }
  }
  public static function valido(){
    return self::$valido;
  }
  public static function msj(){
    return self::$msj;
  }
    
} $numeros=[
        ["verde"],
        ["rojo","impar","falta"],
        ["negro","par","falta"],
        ["rojo","impar","falta"],
        ["negro","par","falta"],
        ["rojo","impar","falta"],
        ["negro","par","falta"],
        ["rojo","impar","falta"],
        ["negro","par","falta"],
        ["rojo","impar","falta"],
        ["negro","par","falta"],
        ["negro","impar","falta"],
        ["rojo","par","falta"],
        ["negro","impar","falta"],
        ["rojo","par","falta"],
        ["negro","impar","falta"],
        ["rojo","par","falta"],
        ["negro","impar","falta"],
        ["rojo","par","falta"],
        ["rojo","impar","pasa"],
        ["negro","par","pasa"],
        ["rojo","impar","pasa"],
        ["negro","par","pasa"],
        ["rojo","impar","pasa"],
        ["negro","par","pasa"],
        ["rojo","impar","pasa"],
        ["negro","par","pasa"],
        ["rojo","impar","pasa"],
        ["negro","par","pasa"],
        ["negro","impar","pasa"],
        ["rojo","par","pasa"],
        ["negro","impar","pasa"],
        ["rojo","par","pasa"],
        ["negro","impar","pasa"],
        ["rojo","par","pasa"],
        ["negro","impar","pasa"],
        ["rojo","par","pasa"]        
      ];
      /* $validador=["rojo","negro","par","impar","falta","pasa"];
          $validador=array_merge($validador,array_keys($numeros));
ValidarInputs::limpio_select("negro",$validador);
          $apuesta=(ValidarInputs::valido())?true: false;
          ValidarInputs::limpio_select(5,["5","10","20","50","100"]);
          $pasta=(ValidarInputs::valido())?true: false;
          var_dump($pasta);
          var_dump($apuesta); */ 
    