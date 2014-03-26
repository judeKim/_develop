<?php

	
	# configuration 

	define( '_SERIVCE_MODE_LOCAL', 			'L' );
	define( '_SERIVCE_MODE_PRODUCTION', 	'P' );

    date_default_timezone_set( 'Asia/Seoul' );

    class CPDOMysql extends PDO {
        public function __construct( $asDSN, $asUser, $asPassword ) {
            parent::__construct( $asDSN, $asUser, $asPassword, array( PDO::ATTR_PERSISTENT => true ) );
        }
    }

	switch( $_SERVER[ 'SERVICE_MODE' ] ) {
		case _SERIVCE_MODE_PRODUCTION :
			$sForwardUrl = 'http://www.lezhin.com';
            define( 'MYSQL_DSN', 'mysql:dbname=logs;host=192.168.4.10;charset=UTF8' );
            define( 'DB_USER', 'judekim' );
            define( 'DB_PASSWD', 'test1234' );
			break;
		case _SERIVCE_MODE_LOCAL : 
		default :
			$sForwardUrl = 'http://www.google.co.kr';
            define( 'MYSQL_DSN', 'mysql:dbname=logs;host=192.168.4.10;charset=UTF8' );
            define( 'DB_USER', 'judekim' );
            define( 'DB_PASSWD', 'test1234' );
			break;
	}

    $objDB = new CPDOMysql( MYSQL_DSN, DB_USER, DB_PASSWD );
    $objStatement = $objDB->prepare( sprintf( "
        INSERT INTO
        %s
          ( `date`, `destination`, `ip`, `mode` )
        VALUES
          ( ?, ?, ?, ? )
        "
        , 'redirect_log'
    ));

    $arrParameter = array(
        date( "Y-m-d H:i:s" )
        , $sForwardUrl
        , $_SERVER[ 'REMOTE_ADDR' ]
        , $_SERVER[ 'SERVICE_MODE' ]
    );

    $bResult = $objStatement->execute( $arrParameter );

	# end configuration
	Header( sprintf( 'Location:%s', $sForwardUrl ) );