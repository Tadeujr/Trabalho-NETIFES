<?php
	// lerArqdic retorna um dicionario do arquivo csv
	function lerArqdic($nomearq,$dicionario){
		$arquivo = fopen($nomearq.".csv","r"); // recebe apenas a str do nome do arquivo csv 
		$lstsaida = array(); // lista auxliar para o retorno
		$linha = array();

		while(!feof($arquivo)){

			$filme = fgetcsv($arquivo);
			for ($i=0; $i < count($filme); $i++){
				$linha[$dicionario[$i]] = $filme[$i];
			}
			array_push($lstsaida,$linha);
			
		
		}
		fclose($arquivo);
		return $lstsaida;
	}
	//Imprime o catálogo de filmes
	function imprimeCatalogo($dic){
		
			foreach($dic as $linha){
				echo "<div class= 'col-sm-3 col-lg-3 col-md-3'>
				        <div class='thumbnail'>
				            <img src='".$linha['CAPA']."' style='height:268px';/>
				            <div class='caption'>
				                <h4><a href='filme.php?filme=".$linha['NOME']."'>".$linha['NOME']."</a>
				                </h4>
				                <h5>".$linha['SUBTITULO']."
				                </h5>
				                <p>".$linha['DIREÇÃO']."</p>
				               
				            </div>
				            <div class='ratings'>
				                
				                <p>";
				                    imprimeEstrelas($linha['AVALIAÇÃO']);
				echo"            </p>
				            </div>
				        </div>
		            </div>";
					
			}
				
	}
	//Imprime as demais informacoes de somente filme, a entrada é um array com as informacoes do filme
	function imprimeFilme($filme){
		echo"<div class='row'>
			    <div class='col-lg-12'>
				<h1 class='page-header'>".$filme['NOME']."
				    <small>".$filme['SUBTITULO']."</small>
				</h1>
			    </div>
			</div>
		<div class='row'>
            		<div class='col-md-8'>
			<!--img class='img-responsive' src='".$filme['CAPA']."' alt=''-->
			<iframe width='750' height='500'src='".$filme['VIDEO']."'>
			</iframe>
					<p><b>".$filme['VIEW']."</b> visualizações</p>
		    </div>

		    <div class='col-md-4'>
		        <h4>".$filme['NOME'].":".$filme['SUBTITULO']."</h4>
					<p>"
					.imprimeEstrelas($filme['AVALIAÇÃO']).
					"</p>
		        <p><b>Sinopse:</b>".$filme['SINOPSE']."</p>
		        <p><b>Elenco:</b>".$filme['ELENCO']."</p>
					<h4>Detalhes</h4>
		        <ul>
		            <li><b>Duração:</b> ".$filme['DURAÇÃO']."</li>
		            <li><b>Anor:</b> ".$filme['ANO']."</li>
		            <li><b>Gênero:</b> ".$filme['GENERO']."</li>
		            <li><b>Direção:</b> ".$filme['DIREÇÃO']."</li>
						<li><b>País:</b> ".$filme['PAÍS']."</li>
						<li><b>Língua:</b> ".$filme['IDIOMA']."</li>
			</ul>
		</div>";
	}
	//Imprime estrelas de avaliação
	function imprimeEstrelas($star){
		$j = 0;
		for ($i=0 ; $i < 5; $i++){
			if ($j <= $star-1){
				echo "<span class='glyphicon glyphicon-star'></span>";
				$j++;
			}else{
		        	echo "<span class='glyphicon glyphicon-star-empty'></span>";
			}
		}
	}

	//troca a posição do elemento
	function troca($vet,$i,$j){
	$aux = $vet[$i];
	$vet[$i] = $vet[$j];
	$vet[$j] = $aux;
	
	return $vet;
	} 
	
	// ordena de por chaves em ordem crescente ou decrescente
	function ordenaParam($vetelem,$param,$ordem){
		$param = strtoupper($param);
		
		for($j = count($vetelem)-1; $j>0; $j--){
			for($i=0;$i<$j;$i++){
				if((trim($vetelem[$j][$param]) < trim($vetelem[$i][$param])) == $ordem){
					$vetelem = troca($vetelem,$j,$i);
				}
			}
		}
		
		return $vetelem;
	}
	//Busca genero no dicionario
	function buscaGen($vet,$genero){ // vamos aproveitar essa função para busca o param
		$aux = array();
		
		for($i = 0; $i <count($vet); $i++){
			if(trim($vet[$i]["GENERO"]) == $genero){
				array_push($aux,$vet[$i]);
			}
		}	
		return $aux;
	}
	
	// busca por palavra chave
	function buscaStr($vet,$busca){
		$saida = array();
		$busca = strtoupper($busca);
		for($i=0;$i<count($vet);$i++){
			$elemN = strtoupper(trim($vet[$i]["NOME"]));
			$elemA = strtoupper(trim($vet[$i]["ELENCO"]));
			$elemD = strtoupper(trim($vet[$i]["DIREÇÃO"]));
			if(substr_count($elemN,$busca) > 0 || substr_count($elemA,$busca) > 0 || substr_count($elemD,$busca) > 0){
				array_push($saida,$vet[$i]);
				
			}
		}
		return $saida;
	}	
	
	
	//Páginação
	function pagina($dic,$pagina){
		$fim = FALSE;
		$aux = array();
		
		for ($i=($pagina*8)-8; $i < $pagina*8 and !$fim; $i++){
			
			if ($i >= count($dic)){
				$fim = TRUE;
			}else{			
				array_push($aux,$dic[$i]);
			}
		}
		
		return($aux);
	}

	function imprimePaginas($n){
		if ($n%8 != 0) $x=($n/8)+1;
		else $x= $n/8;
		//echo $x;
		for ($i=1; $i <= $x; $i++){
			//echo $i;
			echo "<li><a href='?pagina=".$i."'>".$i."</a></li>";
		}	
	}
	/*
	$dicFilmes = array("NOME","SUBTITULO","SINOPSE","DURAÇÃO","ANO","CAPA","VIDEO","GENERO","ELENCO","DIREÇÃO","IDIOMA","PAÍS","AVALIAÇÃO","VIEW");
	$filmes = lerArqdic('filmes',$dicFilmes);
	print_r(buscaStr($filmes,"Morgan Freeman"));
	*/
?>
