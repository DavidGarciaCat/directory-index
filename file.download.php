<?php

#	****************************************************************
#	Obtiene y descodifica los parámetros: nombre y ruta del archivo
#	****************************************************************

	$file = $_GET['file'];
	$file = base64_decode( $file );

	$path = $_GET['path'];
	$path = base64_decode( $path );

#	echo '<pre>'. print_r( $_GET , true ) .'</pre>' ;
#	echo '<pre>file => '. $file .'</pre>' ;
#	echo '<pre>path => '. $path .'</pre>' ;
#	exit();

#	****************************************************************
#	Fuerza la descarga del archivo
#	****************************************************************

	header ( "Content-Type: application/force-download" ) ;
	header ( "Content-Type: application/octet-stream" ) ;
	header ( "Content-Type: application/download" ) ;

	header ( "Content-Disposition: attachment ; filename=". $file ."" ) ;

	header ( "Content-Transfer-Encoding: binary" ) ;
	header ( "Content-Length: " . filesize ( $path ) ) ;

	readfile ( $path ) ;

	die(); exit();

?>