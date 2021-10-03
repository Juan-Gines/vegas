<?php
  class Contexto {
    static function contexto($tipo,$contenido=""){
      $contenido=json_encode($contenido);
      switch ($tipo) {
        case 'get':
          $opc=["http"=>["ignore_errors"=>true]];
          break;
        case 'delete':
          $opc=["http"=>[
            "method"=>"DELETE",
            "ignore_errors"=>true
          ]];
          break;
        case 'put':
          $opc=["http"=>[
            "method"=>"PUT",
            "ignore_errors"=>true,
            "header"=>['Content-Type:application/json; charset=utf-8'],
            "content"=>$contenido
          ]];
          break;
        case 'post':
          $opc=["http"=>[
            "method"=>"POST",            
            "ignore_errors"=>true,
            "header"=>["Content-type: application/json; charset=utf-8"],
            "content"=>$contenido
          ]];
          break;
      }
      $contexto=stream_context_create($opc);   
      return $contexto;
    }    
  }