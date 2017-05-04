<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

ob_start();

$data = stream_get_contents(STDIN);

$lambdaInput = json_decode($data, true);

if(!isset($_SERVER)) {
	$_SERVER = [];
}

$_SERVER['HTTPS'] = 'on';
//$_SERVER['HTTP_HOST'] = '4yloot81ub.execute-api.ap-southeast-2.amazonaws.com';


register_shutdown_function(function(){
	$headers = php_sapi_name() === 'cli' ? xdebug_get_headers() : headers_list();
	$httpCodes = [
		100 =>  'Continue',
		101 =>  'Switching Protocols',
		200 =>  'OK',
		201 =>  'Created',
		202 =>  'Accepted',
		203 =>  'Non-Authoritative Information',
		204 =>  'No Content',
		205 =>  'Reset Content',
		206 =>  'Partial Content',
		300 =>  'Multiple Choices',
		301 =>  'Moved Permanently',
		302 =>  'Moved Temporarily',
		303 =>  'See Other',
		304 =>  'Not Modified',
		305 =>  'Use Proxy',
		400 =>  'Bad Request',
		401 =>  'Unauthorized',
		402 =>  'Payment Required',
		403 =>  'Forbidden',
		404 =>  'Not Found',
		405 =>  'Method Not Allowed',
		406 =>  'Not Acceptable',
		407 =>  'Proxy Authentication Required',
		408 =>  'Request Time-out',
		409 =>  'Conflict',
		410 =>  'Gone',
		411 =>  'Length Required',
		412 =>  'Precondition Failed',
		413 =>  'Request Entity Too Large',
		414 =>  'Request-URI Too Large',
		415 =>  'Unsupported Media Type',
		500 =>  'Internal Server Error',
		501 =>  'Not Implemented',
		502 =>  'Bad Gateway',
		503 =>  'Service Unavailable',
		504 =>  'Gateway Time-out',
		505 =>  'HTTP Version not supported'
	];

	$statusCode = 200;
	$resultHeaders = [];
	foreach($headers as $header) {
		$pos = strpos( $header, ':');
		$headerName = substr($header, 0, $pos);
		$headerValue = substr($header, $pos+1);

		$resultHeaders[$headerName] = trim($headerValue);

		foreach($httpCodes as $code => $codeText) {
			if(strpos($header, $codeText) !== false) {
				$statusCode = $code;
			}
		}
	}

	echo json_encode([
		'headers'=> $resultHeaders,
		'statusCode' => $statusCode,
		'body' => ob_get_clean(),
	]);
});

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
