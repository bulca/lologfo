<?php
$realm = 'Restricted area';
header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
header('Server: Apache');
header('Content-Type: text/html');
header('Content-Length: 0');

//if ($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) {
	/*
	$my_img = imagecreate( 200, 80 );
	$background = imagecolorallocate( $my_img, 0, 0, 255 );
	$text_colour = imagecolorallocate( $my_img, 255, 255, 0 );
	$line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
	imagestring( $my_img, 4, 30, 25, "thesitewizard.com", $text_colour );
	imagesetthickness ( $my_img, 5 );
	imageline( $my_img, 30, 45, 165, 45, $line_colour );

	header( "Content-type: image/png" );
	imagepng( $my_img );
	imagecolordeallocate( $line_color );
	imagecolordeallocate( $text_color );
	imagecolordeallocate( $background );
	imagedestroy( $my_img );*/
    //echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    //echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
    //file_put_contents('got.txt', $_SERVER['PHP_AUTH_USER'] . "\t\t" . $_SERVER['PHP_AUTH_PW'] + "\n", FILE_APPEND);
//}
?>