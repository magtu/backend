<?php

namespace App;

class Router {
	public static function process() {
		$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		//index
		if ($url_path == '/') {
			\Views\ViewHelper::render('schedule', \Models\Group::schedule(62));
			return;
		}
		$uri_parts = explode('/', trim($url_path, ' /'));
		//g437 or t115 or Эавб
		if (count($uri_parts) == 1) {
			$url_path = rawurldecode($uri_parts[0]);
			$url_path = str_replace('_',' ', $url_path);
			$search_result = Search::query($url_path);
			//открыть страницу группы или страницу с поиском
			if (count($search_result) == 0) {
				Router::page404();
				return;
			}
			if (count($search_result) == 1) {
				$groupSchedule = Router::getSchdule($search_result[0]['id']);
				include '../Views/index.php';
				return;
			}
			echo json_encode($search_result, JSON_UNESCAPED_UNICODE);
			return;
		}
		// api/v1/...
		if (count($uri_parts) >= 2 and $uri_parts[0]=='api') {
			$prefix = substr($uri_parts[1],0,1);
			$version = intval(substr($uri_parts[1], 1));
			$classname = 'Api\\v'.$version.'\\ApiController';
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
		//залогировать, незряж стучаться сюда
		echo '404';
		exit;
	}
}
