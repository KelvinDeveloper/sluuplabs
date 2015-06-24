<?php
class RunFunction{
	function GetBrowser(){
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 
	    $bname = 'Unknown';
	    $platform = 'Unknown';
	    $version = "";

	    if ( preg_match('/linux/i', $u_agent ) ) {
	        $platform = 'Linux';
	    }
	    else if ( preg_match('/macintosh|mac os x/i', $u_agent ) ) {
	        $platform = 'Mac';
	    }
	    else if ( preg_match('/windows|win32/i', $u_agent ) ) {
	        $platform = 'Windows';
	    }
	    
	    if( preg_match( '/MSIE/i', $u_agent ) && !preg_match( '/Opera/i', $u_agent ) ) 
	    { 
	        $bname = 'Internet Explorer'; 
	        $ub = "MSIE"; 
	    } 
	    else if( preg_match('/Firefox/i',$u_agent ) ) 
	    { 
	        $bname = 'Mozilla Firefox'; 
	        $ub = "Firefox"; 
	    } 
	    else if( preg_match( '/Chrome/i', $u_agent ) ) 
	    { 
	        $bname = 'Google Chrome'; 
	        $ub = "Chrome"; 
	    } 
	    else if( preg_match( '/Safari/i', $u_agent ) ) 
	    { 
	        $bname = 'Apple Safari'; 
	        $ub = "Safari"; 
	    } 
	    else if( preg_match( '/Opera/i', $u_agent ) ) 
	    { 
	        $bname = 'Opera'; 
	        $ub = "Opera"; 
	    } 
	    else if( preg_match( '/Netscape/i', $u_agent ) ) 
	    { 
	        $bname = 'Netscape'; 
	        $ub = "Netscape"; 
	    } 
	    
	    $known = array( 'Version', $ub, 'other' );
	    $pattern = '#(?<browser>' . join( '|', $known ) .
	    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	    if ( !preg_match_all( $pattern, $u_agent, $matches ) ) {
	    }
	    
	    $i = count( $matches['browser'] );
	    if ( $i != 1 ) {
	        if ( strripos( $u_agent,"Version" ) < strripos( $u_agent, $ub ) ){
	            $version = $matches['version'][0];
	        }
	        else {
	            $version = $matches['version'][1];
	        }
	    }
	    else {
	        $version = $matches['version'][0];
	    }
	    
	    if ( $version == null || $version == ""){ $version = "?"; }
	    
	    return array(
	        'userAgent'  => $u_agent,
	        'name'       => $bname,
	        'version'    => $version,
	        'platform'   => $platform,
	        'pattern'    => $pattern
	    );
	}

	function RemoveAccents($txt){ 
		$txt = trim($txt);

		$array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç" 
		, "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" ); 
		$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c" 
		, "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" ); 

		$txt = str_replace( $array1, $array2, $txt); 

		// $txt = str_replace( ".", "", $txt);
		// $txt = str_replace( " ", "-", $txt);
		// $txt = str_replace( "_", "-", $txt);
		return strtolower($txt); 
	} 

	function ValidateEmail( $email ) {
	    $conta = "^[a-zA-Z0-9\._-]+@";
	    $domino = "[a-zA-Z0-9\._-]+.";
	    $extensao = "([a-zA-Z]{2,4})$";
	    $pattern = $conta.$domino.$extensao;
	    if ( ereg ( $pattern, $email ) )
	    return true;
	    else
	    return false;
	}

	function FormatName( $nome, $charset = 1 ) {

	    $nome = explode(" ",trim($nome));
	    $correto = "";
	    $i = 1;
	    
	    foreach( $nome as $valor ) {
	        $valor = ( ( $charset == 1 ) ? mb_strtolower( $valor ) : strtolower ( $valor ) );
	        
	        //Adiciona espaco se nao for o primeiro nome
	        if($i != 1) { $correto .= " "; }

	        if($valor != "das" && 
	            $valor != "dos" && 
	            $valor != "e" && 
	            $valor != "da" && 
	            $valor != "de" && 
	            $valor != "das" && 
	            $valor != "do") {
	            //Primeira letra maiuscula e restante minuscula
	            
	            
	            $correto .= ( ( $charset == 1 ) ? mb_strtoupper( mb_substr( $valor, 0, 1 ) ) : strtoupper( substr( $valor, 0, 1 ) ) );
	            $correto .= ( ( $charset == 1 ) ? mb_substr( $valor, 1 ) : substr( $valor, 1 ) );
	        } else {
	            $correto .= $valor;
	        }

	        $i++;
	    
	    }

	    return $correto;
	}

	function GetMonth( $n ){

	    $month[1] = 'Janeiro';
	    $month[2] = 'Fevereiro';
	    $month[3] = 'Março';
	    $month[4] = 'Abril';
	    $month[5] = 'Maio';
	    $month[6] = 'Junho';
	    $month[7] = 'Julho';
	    $month[8] = 'Agosto';
	    $month[9] = 'Setembro';
	    $month[10] = 'Outubro';
	    $month[11] = 'Novembro';
	    $month[12] = 'Dezembro';

	    $month['01'] = 'Janeiro';
	    $month['02'] = 'Fevereiro';
	    $month['03'] = 'Março';
	    $month['04'] = 'Abril';
	    $month['05'] = 'Maio';
	    $month['06'] = 'Junho';
	    $month['07'] = 'Julho';
	    $month['08'] = 'Agosto';
	    $month['09'] = 'Setembro';
	    $month['10'] = 'Outubro';
	    $month['11'] = 'Novembro';
	    $month['12'] = 'Dezembro';

	    return $month[$n];
	}

	function SizeConvert( $bytes ){
	    $bytes = floatval( $bytes );
	        $arBytes = array(
	            0 => array(
	                "UNIT" => "TB",
	                "VALUE" => pow( 1024, 4 )
	            ),
	            1 => array(
	                "UNIT" => "GB",
	                "VALUE" => pow( 1024, 3 )
	            ),
	            2 => array(
	                "UNIT" => "MB",
	                "VALUE" => pow( 1024, 2 )
	            ),
	            3 => array(
	                "UNIT" => "KB",
	                "VALUE" => 1024
	            ),
	            4 => array(
	                "UNIT" => "B",
	                "VALUE" => 1
	            ),
	        );

	    foreach ($arBytes as $arItem )
	    {
	        if( $bytes >= $arItem["VALUE"] )
	        {
	            $result = $bytes / $arItem["VALUE"];
	            $result = str_replace( ".", "," , strval( round( $result, 2 ) ) ) . " " . $arItem["UNIT"];
	            break;
	        }
	    }
	    return $result;
	}

	function isAjax() {

		if(	isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 
			strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' ) {
			return true;
		} else {
			return false;
		}
	}

	function dataSize( $Bytes ) {

		$Type = array( "", "KB", "MB", "GB", "TB" );
		$counter = 0;

		while( $Bytes >= 1024 ) {
			$Bytes /= 1024;
			$counter++;
		}
		return round( $Bytes ) . $Type[$counter];
	}

	function WebsocketUser( $clientID ){
		global $Database;

		$Socket = $Database->Search('user_status', false, false, "date DESC", false, 1, false );

		if( !empty( $Socket ) ){
			$Database->Update('user_status', "status='1', ide_websocket='" . ( $clientID ) . "'", "id_user_status='" . ( $Socket->id_user_status ) . "'");
		}

		return $Socket->ide_user;
	}

	function InitialScript(){
		list($usec, $sec) = explode(' ', microtime());
		return (float) $sec + (float) $usec;
	}
	function EndsScript( $script_start ){
		list($usec, $sec) = explode(' ', microtime());
		$script_end = (float) $sec + (float) $usec;
		return round($script_end - $script_start, 5);
	}

	function IPAdress(){
		$hostname = gethostbyaddr( $_SERVER['REMOTE_ADDR'] );
		$sigla = substr( $hostname, -3 );

		$sigla = str_replace( '.', '', $sigla );

		if($sigla == 'org'){ 
			$sigla = "us";
		} else if($sigla == 'net'){ 
			$sigla = "us";
		} else if($sigla == 'com'){ 
			$sigla = "us";
		} else if( is_numeric( $sigla ) ){
			return false;
		}

		return $sigla;
	}

	//Esta Função transforma o texto em minúsculo respeitando a acentuação
	function str_minuscula($texto) { 
	    $texto = strtr(strtolower($texto),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞßÇ","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿç"); 
	    return $texto; 
	} 

	//Esta Função transforma o texto em maiúsculo respeitando a acentuação
	function str_maiuscula($texto) { 
	    $texto = strtr(strtoupper($texto),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿç","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞßÇ"); 
	    return $texto; 
	} 

	//Esta Função transforma a primeira letra do texto em maiúsculo respeitando a acentuação
	function primaira_maiuscula($texto) { 
	    $texto = strtr(ucfirst($texto),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞßÇ","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿç"); 
	    return $texto; 
	} 

	//Verifica se a palavra está toda em maiúscula
	function comparaPalavraMaiuscula($palavra){
		
	$palavra=str_replace(" ","",$palavra);

	if ($palavra=="") return false;
	if ($palavra=="[:p:]")  return false;
	if (strlen($palavra)<=1) return false;

	$palavra=ereg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));

	if ($palavra == $this->str_maiuscula($palavra))
		return true;

	return false;
	}


	/////////////////////////////////
	//Filtro
	/////////////////////////////////

	function Broker($texto){
		
		//Variáveis
		$pontuacoes=array(",",".","!","?",";");
		
		$array_abreviado=array("vc","tb","jesus","naum","ñ","pq");
		$array_abr_certo=array("você","também","Jesus","não","não","porque");

		//Prepara paragrafo
		$texto=str_replace("
	","[:p:]",$texto);

		//acerta maiúscula e minúscula e inicia as sentenças com a primeira letra maiúscula
		$array=explode(" ",$texto);
		$novo_texto="";
		$tam_array=count($array);

		for ($i=0;$i<$tam_array;$i++){
			$palavra=$array[$i];	

			if($this->comparaPalavraMaiuscula($palavra)) 
				$nova_palavra=$this->str_minuscula($palavra);
			else
				$nova_palavra=$palavra;
		
			$caracter_anterior=substr($array[$i-1],-1);
			$caracter_anterior_paragrafo=substr($array[$i-1],-5);

			if ($caracter_anterior=="." || $caracter_anterior=="!" || $caracter_anterior=="?" || $caracter_anterior_paragrafo=="[:p:]" || $i==0)
				$nova_palavra=$this->primaira_maiuscula($nova_palavra);
		
			$novo_texto.=$nova_palavra." ";
		}

		$texto=$novo_texto;

		//Adicionar espaçoes depois das pontuações e remover antes
		for ($i=0;$i<count($pontuacoes);$i++){
			$ponto=$pontuacoes[$i];
			$texto=str_replace(" ".$ponto." ",$ponto." ",$texto);
			$texto=str_replace(" ".$ponto,$ponto." ",$texto);
			$texto=str_replace($ponto,$ponto." ",$texto);
		}

		//acerta parênteses
		$texto=str_replace(" ( "," (",$texto);
		$texto=str_replace("( "," (",$texto);
		$texto=str_replace("("," (",$texto);
		$texto=str_replace(" ) ",") ",$texto);
		$texto=str_replace(" )",") ",$texto);
		$texto=str_replace(")",") ",$texto);

		//acerta redicencias
		$texto=str_replace(". . .","...",$texto);

		//remove mais de uma ! e ?
		$texto=str_replace("! ! ! ","!",$texto);
		$texto=str_replace("! ! ","!",$texto);
		$texto=str_replace("!!","!",$texto);
		$texto=str_replace("? ? ? ","?",$texto);
		$texto=str_replace("? ? ","?",$texto);
		$texto=str_replace("??","?",$texto);

		//remover espaçoes em branco extras
		$texto=str_replace("   "," ",$texto);
		$texto=str_replace("  "," ",$texto);
		$texto=str_replace("  "," ",$texto);

		//Adicionar paragrafo
		$texto=str_replace("\n","",$texto);
		$texto=str_replace("\r","",$texto);

		for ($i=0;$i<=10;$i++)
			$texto=str_replace("[:p:][:p:]","[:p:]",$texto);

		$array=explode("[:p:]",$texto);
		$novo_texto="";
		$tam_array=count($array);
		for ($i=0;$i<$tam_array;$i++){
			$paragrafo=$array[$i];	
		
			$paragrafo=trim($paragrafo);
			$paragrafo=trim($paragrafo,",");
			$paragrafo=$this->primaira_maiuscula($paragrafo);
		
			if ($paragrafo=="") break;

			$ultimo_caracter=substr($paragrafo,-1);

			if ($ultimo_caracter!='.' && $ultimo_caracter!='!' && $ultimo_caracter!='?' && $ultimo_caracter!=':' && $ultimo_caracter!=';')
				$paragrafo.=".";

			if ($i!=$tam_array)
				$novo_texto.=$paragrafo."

	";

		}

		$texto=$novo_texto;


		//Expandir palavras abreviadas
		$texto=str_replace($array_abreviado,$array_abr_certo,$texto);


		return $texto;

	}

	function RemovePoints( $Value ){
		$Array = array(
			'!', '?', '.', ':', ';', '{', '}', '[', ']', '/', '<', '>', ',', '_', '-', '(', ')'
		);
		$Value = str_replace( $Array, '', $Value );
		return $Value;
	}

	function getIp(){
	 
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))
	    {
	 
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	    {
	 
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else{
	 
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	 
	    return $ip;
	 
	}
}