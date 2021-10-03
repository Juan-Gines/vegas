<?php

        //funcion que escribe una consulta select recibe datos con array['tabla_prin']=nombre tabla principal,['tabla_join']['nombre']=campofk...para las tablas anidadas
				//para los campos seleccionados ['nombcolumna']['alias']=valorcolumna... 
				//para las condiciones['cond_ig']['ncampo']=valor['cond_may']['ncampo']>valor['cond_men']['ncampo']<valor
				//['cond_or_ig']['ncampo']or =valor ['cond_or_may']['ncampo']or >valor ['cond_or_men']['ncampo']or <valor
				//['cond_and_ig']['ncampo']and =valor ['cond_and_may']['ncampo']and >valor ['cond_and_men']['ncampo']and <valor
				//['ordby']['ASC'||'DESC']=campo
class Querys{
	
	static function select($datos){
		$tabla_pri=$datos["tabla_prin"];
		unset($datos["tabla_prin"]);	
		$buscajoin=[];
		if(key_exists("tabla_join",$datos)){
			$join="";
			$buscajoin=[];
			foreach($datos["tabla_join"] as $tab=>$fk){
				$join.="JOIN {$tab} ON {$tabla_pri}.{$fk}={$tab}.{$fk} ";			
				$buscajoin[]=$fk;
			}
			unset($datos["tabla_join"]);
		}

		if(key_exists("cond_ig",$datos)){
			$where="WHERE ";
			foreach($datos["cond_ig"] as $cond=>$val){
				foreach($buscajoin as $bus){
					$cond=($cond==$bus)? $tabla_pri.".".$cond: $cond;
				}
				$val=(is_numeric($val)||is_bool($val)) ? $val." " :"'".$val."' ";
				$where.="{$cond}=".$val." AND ";				
			}
			$where=rtrim($where,"AND ");
			unset($datos["cond_ig"]);
		}

		if(key_exists("ordby",$datos)){
			$order=" ORDER BY ";
			foreach($datos["ordby"] as $modo=>$cam){
				foreach($buscajoin as $bus){
					$cam=($cam==$bus)? $tabla_pri.$cam: $cam;
				}
				$order.="{$cam} {$modo} ";				
			}
			unset($datos["ordby"]);
		}

		if(key_exists("lim",$datos)){
			$limit=" LIMIT {$datos["lim"][0]},{$datos["lim"][1]}";
			unset($datos["lim"]);
		}
		
		if(!empty($datos)){			
			$columnas="";
			foreach($datos as $col=>$alias){
				$ali=(empty($alias))? $col :$col . " AS {$alias}";
				foreach($buscajoin as $bus){
					$ali=($col==$bus)? $tabla_pri.".".$ali: $ali;
				}
				$columnas.=$ali.",";
			}
			$columnas=rtrim($columnas,",");
		}else{
			$columnas="*";
		}
		$query="SELECT {$columnas} FROM {$tabla_pri} ";
		$query.=(isset($join))? $join:"";		
		$query.=(isset($where))? $where:"";
		$query.=(isset($order))? $order:"";
		$query.=(isset($limit))? $limit:"";
		return $query;
	}

	static function post($datos){
		$tabla=$datos["tabla"];
		unset($datos["tabla"]);
		$campos=array_keys($datos);
		$valores=array_values($datos);
		$query="INSERT INTO {$tabla} (";
		for($i=0;$i<count($campos);$i++){
			if($i==count($campos)-1){
				$query.=$campos[$i].") ";				
			}else{
				$query.=$campos[$i].",";
			}
		}
		$query.="VALUES (";
		for($i=0;$i<count($valores);$i++){
			$valores[$i]= (is_numeric($valores[$i])||is_bool($valores[$i])) ?  $valores[$i] : "'".$valores[$i]."'";
			if($i==count($valores)-1){
				$query.=$valores[$i].")";				
			}else{
				$query.=$valores[$i].",";
			}
		}
		return $query;
	}
	
	static function put($datos){
		$tabla_pri=$datos["tabla_prin"];
		unset($datos["tabla_prin"]);
		if(key_exists("cond_ig",$datos)){
			$where="WHERE ";
			foreach($datos["cond_ig"] as $cond=>$val){				
				$val=(is_numeric($val)||is_bool($val)) ? $val." " :"'".$val."' ";
				$where.="{$cond}=".$val." AND ";				
			}
			$where=rtrim($where,"AND ");
			unset($datos["cond_ig"]);
		}
		if(!empty($datos)){			
			$columnas="";
			foreach($datos as $col=>$dato){				
				$columnas.=$col."=".$dato.",";
			}
			$columnas=rtrim($columnas,",");		
		}
		$query="UPDATE {$tabla_pri} SET {$columnas} {$where}";
		return $query;
	}
}
//$q=new Querys();	
/* $array=["tabla_join"=>["usuarios"=>"usu_id","apuesta_bj"=>"apubj_id","partidas"=>"par_id"],
				"cond_ig"=>["usu_id"=>1,"usu_nick"=>"Juan"],
				"ordby"=>["DESC"=>"usu_nick"],
				"lim"=>[0,10],
				//"usu_nick"=>"Manolos","apubj_id"=>"apuesta_id","par_id"=>"partida_id","bj_jugador"=>"Jugada","bj_cupier"=>"",
				"tabla_prin"=>"blackjack"];
echo $q->select($array); */ 
/* $array=["tabla_prin"=>"usuarios","cond_ig"=>["usu_id"=>1],"usu_puntos"=>100000];
echo $q->put($array); */