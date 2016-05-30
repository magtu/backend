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
			$uri_part = $uri_parts[0];
			//get  'g' or 't'
			$prefix = substr($uri_part, 0, 1);
			$id = intval(substr($uri_part, 1));
			if ($id <= 0) {
				Router::page404();
			}
			switch ($prefix) {
				case 'g':
					echo 'g'.$id;
					break;
				case 't':
					echo 't'.$id;
					break;
				default:
					Router::page404();
					break;
			}
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