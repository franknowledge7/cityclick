<?php
	//debemos aumentar el tiempo de session, unos 800 minutos
	//El tiempo viene dado en segundos
	ini_set('session.cookie_lifetime',48000);
	//Sera necesario combinarlo con el valor gc_maxlifetime para que
	//el recolector de basura de php no elimine la cookie antes de su expiración
	ini_set('session.gc_maxlifetime', 48000);
	session_start();
	
	//decimos que tipo de codificacion de caracteres esta la web
	//header('Content-type: text/html; charset=utf-8');
	
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];//URL actual
	date_default_timezone_set('Europe/Dublin');//configurar zona
	ini_set('disable function', 'eval');//portegemos de funciones maliciosas
	require_once('configuracion.php');//llamamos a las constantes y BBDD
	$conn = db_connect();//conectamos con la BBDD
?>