<?php

#	****************************************************************
#	Obtiene y descodifica los parámetros: nombre y ruta del archivo
#	****************************************************************

	$file = $_POST['file'];
	$file = base64_decode( $file );

#	****************************************************************
#	Obtiene y escribe los detalles del archivo
#	****************************************************************

	$detalles = '' ;

	$detalles .= '<div class="detalles" style="display:none;">' ;

	$detalles .= '<a href="javascript:;" style="float:right;" onClick="javascript:HideDetails();">Cerrar</a>' ;

	$detalles .= '<div><u>Nombre:</u> '. pathinfo( $file , PATHINFO_BASENAME ) .'</div>' ;
	$detalles .= '<div><u>Tama&ntilde;o del archivo:</u> '. number_format( ( filesize( $file ) / 1024 ) , 2 , ',' , '.' ) .' KB</div>' ;
	$detalles .= '<div><u>Fecha de creaci&oacute;n:</u> '. date( 'r' , filectime( $file ) ) .'</div>' ;
	$detalles .= '<div><u>&Uacute;ltima modificaci&oacute;n:</u> '. date( 'r' , filemtime( $file ) ) .'</div>' ;
	$detalles .= '<div><u>&Uacute;ltimo acceso:</u> '. date( 'r' , fileatime( $file ) ) .'</div>' ;
	$detalles .= '<div><u>Permiso de escritura:</u> '. ( ( is_writeable( $file ) ) ? 'Editable' : 'Solo lectura' ) .'</div>' ;
#	$detalles .= '<div><u>&Uacute;ltima modificaci&oacute;n:</u> '. date( 'd/m/Y H:i:s' , filectime( $file ) ) .'</div>' ;
	$detalles .= '<div><u>Hash MD5:</u> '. md5_file( $file ) .'</div>' ;
	$detalles .= '<div><u>Hash SHA1:</u> '. sha1_file( $file ) .'</div>' ;

	$detalles .= '</div>' ;

#	****************************************************************
#	Retorna los detalles al JavaScript
#	****************************************************************

	exit( $detalles );

?>