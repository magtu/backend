<?php

class Router {
	public static function process() {
		$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		//index
		if ($url_path == '/') {
			echo 'schedule html';
			return;
		}
		$uri_parts = explode('/', trim($url_path, ' /'));
		//g437 or t115
		if (count($uri_parts) == 1) {
			$url_path = rawurldecode($uri_parts[0]);
			echo json_encode(Search::query($url_path), JSON_UNESCAPED_UNICODE);
			return;
		}
		if ($uri_parts[0]=='api') {
			
		}
		Router::page404();
	}
	private static function page404() {
		echo '404';
		exit;
	}
}