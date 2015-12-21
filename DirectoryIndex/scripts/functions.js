//	****************************************************************
//	Realiza una petición AJAX para obtener el contenido del
//	directorio especificado como parámetro
//	****************************************************************

	function ReadDir( ShowOn , ReadPath )
	{
		$(document).ready(function(){
			if ( !ShowOn ) return false ;
			if ( !ReadPath ) return false ;
			$('#'+ShowOn).slideUp( 200 , function() {
				$('#'+ShowOn).html( $('<img>').attr('src','DirectoryIndex/images/ajax-loader.gif') );
				$('#'+ShowOn).slideDown( 200 , function(){
					$.ajax( 'DirectoryIndex/ajax.readPath.php' , {
						'data' : { 'ReadPath' : ReadPath } ,
						'type' : 'post' ,
						'error' : function(){ alert( 'No se puede leer el contenido del directorio' ); } ,
						'success' : function( data )
									{
										$('#'+ShowOn).slideUp( 200 , function() {
											$('#'+ShowOn).html( data );
											if ( data == '' ) $('#'+ShowOn).html( 'No se han encontrado elementos dentro de este directorio' );
											$('#'+ShowOn).slideDown( 200 );
										} );
									}
					} );
				} );
			} );
		});
	}

//	****************************************************************
//	Muestra u oculta (según proceda) el contenido de un directorio
//	Si todavia no se ha cargado el contenido, lo hace ahora
//	****************************************************************

	function ShowHide( ElementID , ReadPath )
	{
		$(document).ready(function(){
			if ( !ElementID ) return false ;
			if ( !ReadPath ) return false ;
			if ( $('#'+ElementID).html() == '' )
			{
				ReadDir( ElementID , ReadPath )
			//	$('#'+ElementID).slideToggle( 200 );
				$('#'+ElementID).slideDown( 200 );
			} else {
				$('#'+ElementID).slideUp( 200 );
				$('#'+ElementID).html('');
			}
		});
	}

//	****************************************************************
//	Genera el enlace para ver los detalles de los archivos
//	****************************************************************

	function DetailsLinkGenerator()
	{
		$(document).ready(function(){
			$('.detail_link').attr( 'href' , 'javascript:;' );
			$('.detail_link').click(function(evento){
				var b64 = $().crypt({method:"b64enc",source:'../'+$(this).attr('rel')});
				ShowDetails( b64 );
			});
		});
	}

//	****************************************************************
//	Genera el enlace para descargar archivos
//	****************************************************************

	function DownloadLinkGenerator()
	{
		$(document).ready(function(){
			$('.download_link').attr( 'href' , 'javascript:;' );
			$('.download_link').click(function(){
				var b64_file = $().crypt({method:"b64enc",source:$(this).attr('rel_file')});
				var b64_path = $().crypt({method:"b64enc",source:'../'+$(this).attr('rel_path')});
				$('.download_link').attr( 'href' , 'DirectoryIndex/file.download.php?file='+b64_file+'&path='+b64_path );
			});
		});
	}

//	****************************************************************
//	Genera el enlace para eliminar archivos
//	****************************************************************

	function DeleteLinkGenerator()
	{
		$(document).ready(function(){
			$('.delete_link').attr( 'href' , 'javascript:;' );
			$('.delete_link').click(function(evento){
				var confirmar = confirm( "Confirme que desea eliminar el archivo del disco duro. Esta acción no puede deshacerse." );
				if ( confirmar ) {
					var b64 = $().crypt({method:"b64enc",source:'../'+$(this).attr('rel')});
					$(this).attr( 'href' , 'DirectoryIndex/file.delete.php?file='+b64 );
				}
			});
		});
	}

//	****************************************************************
//	Bloquear o Desbloquear la pantalla, según proceda
//	****************************************************************

	function LockUnlockScreen()
	{
		$('#WebLock').fadeToggle( 200 );
	}

//	****************************************************************
//	Mostrar detalles del archivo especificado como parámetro
//	Se realiza una consulta AJAX para obtener los datos del archivo
//	****************************************************************

	function ShowDetails( File )
	{
		LockUnlockScreen();
		$('#WebDetails').css( 'text-align' , 'center' );
		$('#WebDetails').css( 'top' , '50%' ).css( 'left' , '50%' );
		$('#WebDetails').css( 'margin-left' , '-200px' );
		$('#WebDetails').css( 'margin-top' , ($('#WebDetails').height()/2)*(-1) );
		$('#WebDetails').html( $('<img>').attr('src','DirectoryIndex/images/ajax-loader.gif') );
		$('#WebDetails').fadeIn( 200 , function(){

			$.ajax( 'DirectoryIndex/file.details.php' , {
					'data' : { 'file' : File } ,
					'type' : 'post' ,
					'error' : function(){ alert( 'No se pueden cargar los datos del archivo' ); } ,
					'success' : function( data )
								{
									var margen = (-96) ;
									$('#WebDetails').animate({'margin-top':margen},400,function(){
										$('#WebDetails img').slideUp( 200 , function() {
											$('#WebDetails img').remove();
											$('#WebDetails').html( data );
											$('#WebDetails').css( 'text-align' , 'left' );
											$('#WebDetails .detalles').slideDown( 400 );
										} ) ;
									});
								}
			} ) ;

		} );
	}

//	****************************************************************
//	Ocultar los detalles del archivo que se estan mostrando
//	****************************************************************

	function HideDetails()
	{
		$('#WebDetails .detalles').slideUp( 400 , function() {
			$('#WebDetails .detalles').remove();
			$('#WebDetails').fadeOut( 200 );
			LockUnlockScreen();
		} );
	}
