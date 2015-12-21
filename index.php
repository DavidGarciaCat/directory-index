<?php

/*

#	****************************************************************
#	No almacenar en cache
#	****************************************************************

	header( 'Cache-Control: no-cache, must-revalidate' );
	header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );

#	****************************************************************
#	Incluye el Core del sitio web
#	****************************************************************

	require_once( '../core/include.php' );

#	****************************************************************
#	Obtener el Hash de sesión del cliente
#	****************************************************************

	$session = isset( $_COOKIE["ExtranetHash"] ) ? trim( $_COOKIE["ExtranetHash"] ) : NULL ;

#	****************************************************************
#	Si no hay Hash, redirige al Login
#	****************************************************************

	if ( is_null( $session ) or empty( $session ) ) :
		echo " No ha iniciado sesión en la Extranet. Acceda primero, por favor. " ;
		exit();
	endif ;

#	****************************************************************
#	Escapa la sesión
#	****************************************************************

	$session = $BaseDeDatos->EscapeString( $session );

#	****************************************************************
#	Comprueba que usuario tiene asignada esta sesión
#	****************************************************************

	$select = " SELECT `usuario` FROM `cms_sesiones` WHERE `session` = '". $session ."' AND `origen` = '". $_SERVER['REMOTE_ADDR'] ."' " ;
	$select = $BaseDeDatos->Select( $select );

	if ( $select->Error ) :
		echo " No se puede determinar si ya ha accedido a la Extranet " ;
		exit();
	endif ;

	if ( $select->RegistrosTotales != 1 ) :
		echo " No ha iniciado sesión en la Extranet. Acceda primero, por favor. " ;
		exit();
	endif ;

#	****************************************************************
#	Almacena en una constante el usuario activo
#	****************************************************************

	define( "USUARIO_ACTIVO" , $select->SQLdatos[0]['usuario'] );

#	****************************************************************
#	Si existen otras sesiones iniciadas para este usuario, el
#	sistema las cierra para evitar un exceso de comunicaciones
#	****************************************************************

	$delete = array(
		" DELETE FROM `cms_sesiones` WHERE `usuario` = '". USUARIO_ACTIVO ."' AND `session` <> '". $session ."' " ,
		" OPTIMIZE TABLE  `cms_sesiones` " ,
		" REPAIR TABLE  `cms_sesiones` "
	);
	$delete = $BaseDeDatos->ExecuteTransaction( $delete );

*/

?>

<!DOCTYPE HTML>

<html>

	<head>

		<meta charset="iso-8859-1">

		<title>Directory Index</title>

		<link href="DirectoryIndex/resources/HTML5/html5.css" rel="stylesheet" type="text/css">
		<script src="DirectoryIndex/resources/HTML5/html5.js"></script>

		<link href="DirectoryIndex/css/main.css" rel="stylesheet" type="text/css">
		<link href="DirectoryIndex/css/styles.css" rel="stylesheet" type="text/css">

		<script src="DirectoryIndex/resources/jQuery/jquery-1.7.2.min.js"></script>
		<script src="DirectoryIndex/resources/jQueryCrypt/jquery.crypt.js"></script>

		<script src="DirectoryIndex/scripts/functions.js"></script>
		<script src="DirectoryIndex/scripts/preload.js"></script>

	</head>

	<body>

		<div id="WebBox">
			<div id="WebBoxRoot"></div>
		</div>

		<div id="WebLock"></div>
		<div id="WebDetails"></div>

	</body>

</html>
