<?php

namespace App;

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
			$search_result = Search::query($url_path);
			//открыть страницу группы или страницу с поиском
			echo json_encode($search_result, JSON_UNESCAPED_UNICODE);
			return;
		}
		// api/v1/...
		if (count($uri_parts) >= 2 and $uri_parts[0]=='api') {
			$prefix = substr($uri_parts[1],0,1);
			$version = intval(substr($uri_parts[1], 1));
			$classname = '\\Api\\v'.$version.'\\ApiController';
			if ($prefix == 'v' and $version > 0 and class_exists($classname)) {
				$api = new $classname();
				$api->process(array_slice($uri_parts, 2));
				return;
			} else {
				Router::page404();
				return;
			}
		}
		Router::page404();
	}
	private static function page404() {
		echo '404';
		exit;
	}
}