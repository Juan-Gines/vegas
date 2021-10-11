<?php
class Cartas{
	private $mazo;
	private $palos=[1=>"c",2=>"p",3=>"r",4=>"t"];
	private $cartas=[1=>"As",2=>"2",3=>"3",4=>"4",5=>"5",6=>"6",7=>"7",8=>"8",9=>"9",10=>"10",11=>"J",12=>"Q",13=>"K"];
	//Función constructor que crea un array con un mazo de 6 barajas
	function __construct(){
		for($i=1;$i<7;$i++){
			for($j=1;$j<5;$j++){
				for($k=1;$k<14;$k++){
					if($k>=10){
						$this->mazo["baraja".$i]["palo".$j]["carta".$k]=["baraja"=>$i,"numero"=>$k,"palo"=>$j,"valor"=>10,"usada"=>false];
					}else{
						$this->mazo["baraja".$i]["palo".$j]["carta".$k]=["baraja"=>$i,"numero"=>$k,"palo"=>$j,"valor"=>$k,"usada"=>false];
					}
				}
			}
		}
	}
	//función devuelve el número de cartas que todavía quedan en la baraja
	function cartas_baraja(){
		$contador=0;
		foreach($this->mazo as $baraja){
			foreach($baraja as $palo){
				foreach($palo as $carta){
					if(!$carta["usada"]){
						$contador++;
					}
				}
			}
		}
		return $contador;
	}
	//función coger_carta(triple array):array(info de la carta)
	//para escoger una carta aleatoriamente del mazo que previamente no se haya utilizado.
	function coger_carta() {
		do {
			$bar=mt_rand(1, 6);
			$pal=mt_rand(1, 4);
			$car=mt_rand(1, 13);
			$carta=$this->mazo["baraja".$bar]["palo".$pal]["carta".$car];
		} while ($this->mazo["baraja".$bar]["palo".$pal]["carta".$car]["usada"]);
		$this->mazo["baraja".$bar]["palo".$pal]["carta".$car]["usada"]=true;
		return $carta;
	}
	//función que retorna el valor de las cartas de la jugada
	function valor_total($jugada){
			$suma=0;
			$ases=0;
			foreach ($jugada as $cartas) {
					if ($cartas["valor"]!=1) {
							$suma+=$cartas["valor"];
					} else {
							$suma+=11;
							$ases++;
					}
			}
			if($suma>21&&$ases>0){
					for ($i=0;$i<$ases;$i++) {
							$suma-=10;
							if ($suma<=21) {
									break;
							}
					}
			}
			return $suma;
	}
	//función que imprime la jugada actual
	/* function resultados($cup,$jug,$cartas,$palos){
			echo "<p>";
			foreach ($cup as $carta) {
					echo  $cartas[$carta["numero"]] . $palos[$carta["palo"]] . " ";
			}
			echo valor_total($cup) . "</p>";
			echo "<p>";
			foreach ($jug as $carta) {
					echo  $cartas[$carta["numero"]] . $palos[$carta["palo"]] . " ";
			}
			echo valor_total($jug) . "</p>";
	} */
}
