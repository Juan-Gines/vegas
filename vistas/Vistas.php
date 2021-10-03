<?php
  require_once "controladores/salon/Salon.php";    
  Class Vistas{        
    

    static function cabecera(){
      ?>
      <!DOCTYPE html>
      <html lang="es">
      <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="css/bootstrap-reboot.css">
          <link rel="stylesheet" href="css/bootstrap-reboot.css.map">
          <link rel="stylesheet" href="css/estilo.css">
          <title>YoYa casino</title>
      </head>
      <body>
        <header>
          <img src="imagenes/logo.png" alt="logo">
        </header>
      <?php  
    }

    function login($datos){      
      self::cabecera();
      $id=mt_rand();
      $_SESSION["idrand"]=$id;  
      ?>          
      <main>
        <form action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">          
          <label for="email">Email:</label>
          <input type="text" name="email" id="email" value="<?= (!empty($datos["email"])) ? $datos["email"] : "" ?>">          
          <label for="pass">Password:</label>
          <input type="password" name="pass" id="pass">
          <input type="hidden" name="idrand" id="idrand" value="<?= $id?>">                           
          <button name="login">Login</button>
          <p>Si no tienes cuenta<a href="<?=htmlspecialchars($_SERVER["PHP_SELF"]."?registro")?>"> registrate </a>aquí.
          <output><?= (!empty($datos["pantalla"]))? $datos["pantalla"] : ""?></output>
          </p>          
        </form>
        
      </main>
      <?php
      self::footer();
    }
    
    function registro($datos){
      self::cabecera();
      $id=mt_rand();
      $_SESSION["idrand"]=$id;
      ?>      
      <main> 
        <h3>Registro</h3>              
        <form action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">          
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="email" value="<?= (!empty($datos["usu_email"])) ? $datos["usu_email"]: "" ?>">
          <output><?= (!empty($datos["er_email"]))? " *".$datos["er_email"] : ""?></output><br>
          <label for="pass">Password:</label><br>
          <input type="password" name="pass" id="pass" >
          <output><?= (!empty($datos["er_pass"]))? " *".$datos["er_pass"]: ""?></output><br>
          <label for="pass2">Repite password:</label><br>
          <input type="password" name="pass2" id="pass2" >
          <output><?= (!empty($datos["er_pass2"]))? " *".$datos["er_pass2"]: ""?></output><br>
          <label for="nick">Nick:</label><br>
          <input type="text" name="nick" id="nick" value="<?= (!empty($datos["usu_nick"])) ?$datos["usu_nick"]: "" ?>">
          <output><?= (!empty($datos["er_nick"]))? " *".$datos["er_nick"]: ""?></output><br>
          <label for="fnac">Fecha nacimiento:</label><br>
          <input type="date" name="fnac" id="fnac" placeholder="yyyy-mm-dd" value="<?= (!empty($datos["usu_fnacimiento"])) ?$datos["usu_fnacimiento"]: "" ?>">
          <output><?= (!empty($datos["er_fnac"]))? " *".$datos["er_fnac"]: ""?></output><br>
          <input type="hidden" name="idrand" id="idrand" value="<?= $id?>">                          
          <button name="registro">Regístrate</button> 
          <button name="inicio">Inicio</button>
          <?=(!empty($datos["er_login"]))? $datos["er_login"]: ""?>     
        </form>        
      </main>
      <?php
      self::footer();
    }

    function ban(){
      self::cabecera();
      ?>      
      <main>
        <h2>Estás Baneado</h2>
        <p>Estás baneado por fallar más de 5 intentos de login.</p>
        <p>Cierra el navegador y vuelvelo a abrir.</p>        
      </main>
      <?php
      self::footer();
    }

    function salon(){      
      self::cabecera();             
      ?>      
      <main>
        <h2>Bienvenido <?=$_SESSION["user"]["usu_nick"]?> Dinero: <?=$_SESSION["user"]["usu_puntos"]?>€</h2>
        <div>
          <a href="<?=htmlspecialchars($_SERVER['PHP_SELF']."?ruleta")?>"><button type="button">Ruleta</button></a>
          <a href="<?=htmlspecialchars($_SERVER['PHP_SELF']."?close")?>"><button type="button">Cerrar sesion</button></a>
        </div>    
      </main>
      <?php
      self::footer();
    }

    function ruleta($datos){      
      $id=mt_rand();
      $_SESSION["idrand"]=$id;         
      ?><!DOCTYPE html>
      <html class="ruleta" lang="es">
      <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="css/bootstrap-reboot.css">
          <link rel="stylesheet" href="css/bootstrap-reboot.css.map">
          <link rel="stylesheet" href="css/estilo.css">
          <title>YoYa casino</title>
      </head>
      <body>
        <header>
          <img src="imagenes/logo.png" alt="logo">
        </header>      
      <main>
        <h2>Ruleta</h2>               
        <a href="<?=htmlspecialchars($_SERVER['PHP_SELF']."?volver")?>"><button type="button">Volver</button></a>
          <h3><?=$_SESSION["user"]["usu_nick"]?>  Puntos: <?=$_SESSION["user"]["usu_puntos"]?></h3> 
        <form action="<?=htmlspecialchars($_SERVER["PHP_SELF"]."?ruleta")?>" method="POST">
          
          <label for="apuesta">Apuesta:</label>
          <select name="apuesta">
            <option value="rojo" <?= (isset($datos["apuesta"])&&$datos["apuesta"]=="rojo")?"selected":""?>>Rojo</option>
            <option value="negro" <?= (isset($datos["apuesta"])&&$datos["apuesta"]=="negro")?"selected":""?>>Negro</option>
            <option value="impar" <?= (isset($datos["apuesta"])&&$datos["apuesta"]=="impar")?"selected":""?>>Impar</option>
            <option value="par" <?= (isset($datos["apuesta"])&&$datos["apuesta"]=="par")?"selected":""?>>Par</option>
            <option value="falta" <?= (isset($datos["apuesta"])&&$datos["apuesta"]=="falta")?"selected":""?>>Falta</option>
            <option value="pasa" <?= (isset($datos["apuesta"])&&$datos["apuesta"]=="pasa")?"selected":""?>>Pasa</option>          
            <?php
            for ($i=0;$i<37;$i++) {
                ?>
            <option value=<?=$i?> <?= (isset($datos["apuesta"])&&$datos["apuesta"]==$i)?"selected":""?>><?=$i?></option>
            <?php
            }
            ?>
          </select><br>
          <label for="dinero">Cuanto apuestas:</label>          
          <select name="dinero">
            <option value="5" <?= (isset($datos["dinero"])&&$datos["dinero"]==5)?"selected":""?>>5€</option>
            <option value="10" <?= (isset($datos["dinero"])&&$datos["dinero"]==10)?"selected":""?>>10€</option>
            <option value="20" <?= (isset($datos["dinero"])&&$datos["dinero"]==20)?"selected":""?>>20€</option>
            <option value="50" <?= (isset($datos["dinero"])&&$datos["dinero"]==50)?"selected":""?>>50€</option>
            <option value="100" <?= (isset($datos["dinero"])&&$datos["dinero"]==100)?"selected":""?>>100€</option>
          </select>
          <input type="hidden" name="idrand" id="idrand" value="<?= $id?>">                                    
          <button name="jugada">Juega</button></output>                    
        </form>
            <output class="rul aligncenter <?= (!empty($datos["pantalla"]))? "" : "displayres "?><?= (!empty($datos["pantalla"]))? $datos["pantalla"] : ""?>">
            <?= (!empty($datos["pantalla"]))? $datos["resultado"]."<br>".$datos["pantalla"] : ""?></output><br>    
      </main>
      <?php
      self::footer();
    }
    private static function footer(){
      ?>
        </body>
        </html>
      <?php
    }
  }