<?php

	
	# configuration 

	define( '_SERIVCE_MODE_LOCAL', 			'L' );
	define( '_SERIVCE_MODE_PRODUCTION', 	'P' );

	switch( $_SERVER[ 'SERVICE_MODE' ] ) {
		case _SERIVCE_MODE_PRODUCTION :
			$sForwardUrl = 'http://www.lezhin.com';
			break;
		case _SERIVCE_MODE_LOCAL : 
		default :
			$sForwardUrl = 'http://www.google.co.kr';
			break;
	}

	# end configuration 

	Header( sprintf( 'Location:%s', $sForwardUrl ) );