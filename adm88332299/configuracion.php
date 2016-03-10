<?php
 //en la instruccion DEFINE(nombre_constante, valor_constante)
 //podemos cambiar valor_constante pero nunca nombre_constante para que no haya errores

 //titulos principales
 define("EMPRESA", "EDUCAPP"); //nombre de la empresa
 define("TITULO", "EDUCAPP"); //titulo de la pagina
 define("VERSION", "EDUCAPP 1.0.0"); //version de la aplicacion
 define("DESCRIPCION","Create APP manuals for education");
 define("CLAVES","Create APP manuals for education");
 define("COPYRIGHT", "Francisco Javier barreto garcia"); //copiright
 define("DEF_LANG", "es"); //language by default of the sistem
 define("LANGS" , 'es,en');//languajes defineds

 //rutas de acceso
 define("SITE_URL", "http://localhost/educapp/"); //url del sitio
 define("DIR_ADMIN", "adm88332299/"); //folder del admimnistrador
 define('JPATH_BASE', dirname(__FILE__) );//archivo raiz
 define('PATH_FILES', '../admin_uploads/' );//zona donde se guardan los archivos a partir de admin
 define('PATH_FILES_HOST', 'admin_uploads/' );//zona donde se guardan los archivos a partir del dominio
 
 //configuracion global
 /* medidas de imagenes
 * XBg - YBg: ancho y alto de imagenes grandes
 * XMd - YMd: ancho y alto de imagenes medias
 * XTb - YTb: ancho y alto de imagenes pequeñas
 */
 define("MEDIDAS_IMG","XBg:800,YBg:600,XMd:600,YMd:400,XTb:218,YTb:218");//medidas imagenes
 define("CUT", 'yes');//if cut image (yes) or scale down (reducir proporcionalmente) (no)

 //correo
 define("HOST_SMTP", ''); //Nuestro servidor smtp.
 define("HOST_POP3", ''); //Nuestro servidor pop3.
 define("USER_POP3", ''); //Nuestro servidor pop3.
 define("PASS_POP3", ''); //Nuestro servidor pop3.
 define("SLL", 'ssl');//Nuestro servidor smtp. Como ves usamos cifrado ssl
 define("PUERTO_SMTP", '465'); //puerto SMTP predeterminado=25
 define("DE_NOMBRE", "COMER"); //nobre de FROM de email
 define("EMAIL", "prueba@prueba.com"); //email del webmaster
 define("USER_EMAIL", ""); //email del webmaster
 define("PASS_EMAIL", ""); //email del webmaster
 
  //bases de datos
 define("SERVIDOR", "localhost"); //servidor
 define("DBASE", "educapp"); //nombre de la base de datos
 define("USERADMIN", "root"); //usuario
 define("PSWUSERADMIN", "admin"); //contraseña
 //otras constantes para el acceso a la BBDDD
 
 //conectar con una base de datos........................................
	function db_connect($setcharset='utf8'){
		$host = SERVIDOR;
		$user_BBDD = USERADMIN;
		$pass_BBDD = PSWUSERADMIN;
		$nombre_BBDD = DBASE;
		$result = new mysqli($host, $user_BBDD, $pass_BBDD, $nombre_BBDD);
		//codificacion de caracteres
		if($setcharset == 'utf8'){
			//$result->query("SET NAMES 'utf8'");
			//$result->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
			$conectar = "SET character_set_results='utf8',";
			$conectar .= "character_set_client='utf8',";
			$conectar .= "character_set_connection='utf8',";
			$conectar .= "character_set_database='utf8',";
			$conectar .= "character_set_connection='utf8',";
			$conectar .= "character_set_server='utf8',";
			$conectar .= "collation_connection='utf8_general_ci',";
			$conectar .= "collation_database='utf8_general_ci',";
			$conectar .= "collation_server='utf8_general_ci'";
			$result->query($conectar);
			$result->set_charset("utf8");//definir conjunto de caracteres para usar real_escape_string
			
		}
		if(!$result) echo "No se ha podido conectar con la base de datos";
		else return $result;
	}//fin db_connect
 //conectar con una base de datos........................................
 
 //codificacion de caracteres...........................................
 	header('Content-type: text/html; charset=utf-8');//decimos que tipo de codificacion de caracteres esta la web
	ini_set('default_charset','utf8');
	
	//mb_internal_encoding('UTF-8'); codificacion para la base de datos
	function cod($conn,$str){
		$str = trim($str);
		/*
		* Precaucion:
		* El conjunto de caracteres debe ser establecido a nivel del servidor, o con la función mysqli::set_charset() de la API 
		* para que afecte a mysqli::real_escape_string().
		*/
		$str = $conn->real_escape_string(addslashes($str));
		return $str;
	}//end cod
	
	//codificamos caracteres raros al español
	function codES($str){
		$chasES = array('á','é','í','ó','ú','ú','ñ','ü','Á','Ë','Í','Ó','Ú','Ñ','Ü');
		$chasRAROS = array('Ã¡','í©','Ã','Ã³','íº','Ãº','Ã±','ü','Á','Ë','Í','Ó','Ú',"í‘",'Ü');
		$chasEntitesRAROS = array('&Atilde;&iexcl;','&Atilde;&copy;','&Atilde;&shy;','&Atilde;&sup3;','&Atilde;&ordm;',
		'&Atilde;&ordm;','&Atilde;&plusmn;','&Atilde;&frac14;','Á','Ë','Í','Ó','Ú',"í‘",'Ü');
		$EntHTML = array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&uacute;','&ntilde;','&uuml;',
		'&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&Ntilde;','&Uuml;');
		//$str = str_replace($chasES, $EntHTML, $str);
		$str = str_replace($chasEntitesRAROS, $EntHTML, $str);
		return $str;
	}//end codEs
	
	//decodificacion para mostrar datos en pantalla
	function decod($str){
		$str = trim(stripslashes($str));//quitamos barras invertidas a caracteres especiales
		//$str = utf8_encode($str);
		//$str = htmlentities($str);//convertimos caracteres espanoles a entidades html
		$str = htmlentities($str,ENT_COMPAT,'UTF-8');//convertimos caracteres espanoles a entidades html
		$str = codES($str);
		return $str;
	}//end decod
	
	//mostrar la cofiguracion de caracteres con la que se conecta la BBDD
	function showCharsetConfig($conn){
		$re = $conn->query('SHOW VARIABLES LIKE "c%";')or die(mysql_error());
		$camposA = array('utf8','utf8','utf8','binary','utf8','utf8','utf8','/usr/share/mysql/charsets/','utf8_general_ci','utf8_general_ci','utf8_general_ci','NO_CHAIN','AUTO',10);
		$contPos = 0;
		while ($row = $re->fetch_array(MYSQLI_ASSOC)){
			echo $row['Variable_name'].': '.$row['Value']; echo ' Debe ser: '.$camposA[$contPos].' <br>';
			$contPos++;
		}
		$caracteres = $conn->character_set_name();echo $caracteres;//ver la configuracion de caracteres con la que se conecata la BBDD
	}//fin showCharsetConfig
	
	//asegurar que un numero sea un entero positivo.
	function absint($maybeint){
		
		//abs Devuelve un valor absoluto
		//intval: Obtiene el valor entero de una variable
		return abs(intval($maybeint));
		
	}//end absint
	
	//convertir valor en float
	function float_dot($valor){
		
		//primero sustituimos la coma, si la hay, en punto
		$valor = str_replace(',','.',$valor);
		//convertir a float
		$valor = (float) $valor;
		//devolvemos valor
  		return $valor;

	}//end float_dot()
	
	//showCharsetConfig($conn);
 //codificacion de caracteres...........................................
 
setlocale(LC_MONETARY, 'es_ES');//muestra el formato internacional de moneda para la configuración regional es_ES

//cuando money_format no se encuentra. cargamos esta funcion
if(!function_exists('money_format')) {//si la funcion no existe
 
 function money_format($format, $number){ 
    $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'. '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/'; 
    if (setlocale(LC_MONETARY, 0) == 'C') { setlocale(LC_MONETARY, ''); } 
    $locale = localeconv(); 
    preg_match_all($regex, $format, $matches, PREG_SET_ORDER); 
    foreach ($matches as $fmatch) { 
        $value = floatval($number); 
        $flags = array( 
            'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ? 
                           $match[1] : ' ', 
            'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0, 
            'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ? 
                           $match[0] : '+', 
            'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0, 
            'isleft'    => preg_match('/\-/', $fmatch[1]) > 0 
        ); 
        $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0; 
        $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0; 
        $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits']; 
        $conversion = $fmatch[5]; 

        $positive = true; 
        if ($value < 0) { 
            $positive = false; 
            $value  *= -1; 
        } 
        $letter = $positive ? 'p' : 'n'; 
        $prefix = $suffix = $cprefix = $csuffix = $signal = ''; 
        $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign']; 
        switch (true) { 
            case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+': 
                $prefix = $signal; 
                break; 
            case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+': 
                $suffix = $signal; 
                break; 
            case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+': 
                $cprefix = $signal; 
                break; 
            case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+': 
                $csuffix = $signal; 
                break; 
            case $flags['usesignal'] == '(': 
            case $locale["{$letter}_sign_posn"] == 0: 
                $prefix = '('; 
                $suffix = ')'; 
                break; 
        } 
        if (!$flags['nosimbol']) { 
            $currency = $cprefix . ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) . $csuffix; 
        } else $currency = ''; 

        $space  = $locale["{$letter}_sep_by_space"] ? ' ' : ''; 
        $value = number_format($value, $right, $locale['mon_decimal_point'], $flags['nogroup'] ? '' : $locale['mon_thousands_sep']); 
        $value = @explode($locale['mon_decimal_point'], $value); 
        $n = strlen($prefix) + strlen($currency) + strlen($value[0]); 
        if ($left > 0 && $left > $n) $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0]; 
        $value = implode($locale['mon_decimal_point'], $value); 
        if ($locale["{$letter}_cs_precedes"]) $value = $prefix . $currency . $space . $value . $suffix; 
        else $value = $prefix . $value . $space . $currency . $suffix; 
        if ($width > 0) $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ? STR_PAD_RIGHT : STR_PAD_LEFT);
        $format = str_replace($fmatch[0], $value, $format); 
    } 
    return $format; 
 }//fin funcion money_format
}//fin si funcion money_format no exite
?>