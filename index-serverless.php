<?php

ob_start();

$lambdaInput = json_decode(file_get_contents("php://stdin"), true);
$headers = isset($lambdaInput['headers']) && is_array($lambdaInput['headers'])
				 ? $lambdaInput['headers']
				 : [];

$get = isset($lambdaInput['queryStringParameters']) && is_array($lambdaInput['queryStringParameters'])
		 ? $lambdaInput['queryStringParameters']
		 : [];

if(!isset($_SERVER)) {
	$_SERVER = [];
}

$_SERVER['HTTPS'] = 'on';
$_SERVER['REQUEST_SCHEME'] = 'https';
$_SERVER['REQUEST_METHOD'] = $lambdaInput['httpMethod'];
$_SERVER['REQUEST_URI'] = $lambdaInput['path'];

foreach($headers as $headerName => $headerValue) {
	$phpName = 'HTTP_' .strtoupper(str_replace('-', '_', $headerName));
	$_SERVER[$phpName] = $headerValue;
}

foreach($get as $key => $value) {
	$_GET[$key] = $value;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	parse_str($lambdaInput['body'], $_POST);
}

if($_SERVER['HTTP_COOKIE']) {
	$_COOKIE = [];
	$headerCookies = explode('; ', $_SERVER['HTTP_COOKIE']);

	foreach($headerCookies as $cookie) {
			list($key, $val) = explode('=', $cookie, 2);

			$_COOKIE[$key] = urldecode($val);
	}
}

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
