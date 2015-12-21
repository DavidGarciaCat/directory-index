<?php

#	****************************************************************
#	Genera 2 segundos de retraso para que el proceso de carga AJAX
#	no genere unos saltos excesivamente rápidos
#	****************************************************************

#	sleep( 2 );

#	****************************************************************
#	Incluye archivos de configuración
#	****************************************************************

	require_once( 'cfg.DirectoryIndex.php' );

#	****************************************************************
#	Recibe la ruta a leer
#	Establece dicha ruta en una variable
#	****************************************************************

	$ReadPath = isset( $_POST['ReadPath'] ) ? trim( $_POST['ReadPath'] ) : './' ;

	$RealPath = realpath( realpath( dirname( __FILE__ ) ) .'/../' ) .'/' ;
	$RealPath .= $ReadPath ;

#	****************************************************************
#	Abre y lee el directorio
#	Almacena los Archivos en un Array
#	Almacena los Directorios en otro Array
#	****************************************************************

	$ArrayArchivos = array();
	$ArrayDirectorios = array();

	$OpenDir = opendir( $RealPath );
	while ( false !== ( $ReadDir = readdir( $OpenDir ) ) ) :
		if ( !in_array( $ReadDir , $Exclude ) ) :
			if ( is_file( $RealPath.$ReadDir ) ) :
				$ArrayArchivos[ $ReadDir ] = $ReadPath.$ReadDir ;
			elseif ( is_dir( $RealPath.$ReadDir ) ) :
				$ArrayDirectorios[ $ReadDir ] = $ReadPath.$ReadDir.'/' ;
			endif ;
		endif ;
	endwhile ;

#	****************************************************************
#	Ordena los elementos
#	****************************************************************

	asort( $ArrayArchivos );
	asort( $ArrayDirectorios );

#	****************************************************************
#	Variable de control
#	Una linea en blanco, una línea en gris
#	****************************************************************

	$linea = true ;
	$color = array( 'FFF' , 'F4F4F4' );

#	****************************************************************
#	Escribe el código HTML de los directorios
#	****************************************************************

	if ( count( $ArrayDirectorios ) > 0 ) :

	?> <ul class="FolderList"> <?php

	foreach( $ArrayDirectorios as $Nombre => $Ruta ) :
		?>
			<li style="background:#<?php if ( $linea == true ) : echo $color[0] ; else : echo $color[1] ; endif ; ?>;">
				<a id="a_<?php echo md5( $Ruta ); ?>" href="javascript:;" onClick="ShowHide('div_<?php echo md5( $Ruta ); ?>','<?php echo $Ruta ; ?>');"><?php echo $Nombre ; ?></a>
				<div id="div_<?php echo md5( $Ruta ); ?>"></div>
			</li>
		<?php
		if ( $linea == true ) $linea = false ; else $linea = true ;
	endforeach ;

	?> </ul> <?php

	endif ;

#	****************************************************************
#	Escribe el código HTML de los archivos
#	****************************************************************

	if ( count( $ArrayArchivos ) > 0 ) :

	?> <ul class="FilesList"> <?php

	foreach( $ArrayArchivos as $Nombre => $Ruta ) :
		if ( $Ruta != "./index.php" ) :
		?>
			<li style="background:#<?php if ( $linea == true ) : echo $color[0] ; else : echo $color[1] ; endif ; ?>;">
				<a href="<?php echo $Ruta ; ?>" target="_blank"><?php echo $Nombre ; ?></a>
				<ul class="FolderActions">
					<li class="detail"><a class="detail_link" rel="<?php echo ( $Ruta ); ?>">Detalles</a></li>
					<li class="download"><a class="download_link" rel_file="<?php echo ( $Nombre ); ?>" rel_path="<?php echo ( $Ruta ); ?>">Descargar</a></li>
					<?php if ( is_writeable( '../'.$Ruta ) and ( $Ruta != './index.php' ) ) : ?>
					<li class="delete"><a class="delete_link" rel="<?php echo ( $Ruta ); ?>">Eliminar</a></li>
					<?php endif ; ?>
				</ul>
			</li>
		<?php
		if ( $linea == true ) $linea = false ; else $linea = true ;
		endif ;
	endforeach ;

	?> <script> DetailsLinkGenerator(); </script> <?php
	?> <script> DownloadLinkGenerator(); </script> <?php
	?> <script> DeleteLinkGenerator(); </script> <?php

	?> </ul> <?php

	endif ;

?>