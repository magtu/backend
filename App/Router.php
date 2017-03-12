<?php

namespace App;

class Router {
	public static function process() {
		$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		//index
		if ($url_path == '/') {
			//echo 'read from cookie';
			\Views\ViewHelper::render('search', NULL);
			return;
		}
		$uri_parts = explode('/', trim($url_path, ' /'));
		//g437 or t115 or Эавб
		if (count($uri_parts) == 1) {
			$url_path = rawurldecode($uri_parts[0]);
			$search_result = Search::query($url_path);
			//открыть страницу группы или страницу с поиском
			if (count($search_result) == 0) {
				\Views\ViewHelper::renderError(404);
				return;
			}
			if (count($search_result) == 1) {
				if ($url_path != $search_result[0]['url']) {
					header('Location: http://'.$_SERVER['HTTP_HOST'].'/'.$search_result[0]['url'], true, 302);
					return;
				}
				$id = $search_result[0]['id'];
				if ($search_result[0]['type'] == 'group') {
					\Views\ViewHelper::render('schedule', \Models\v2\Group::schedule($id));
				} elseif ($search_result[0]['type'] == 'teacher') {
					\Views\ViewHelper::render('schedule', \Models\v2\Teacher::schedule($id));
				}
				return;
			}
			//echo json_encode($search_result, JSON_UNESCAPED_UNICODE);

			\Views\ViewHelper::render('matches', $search_result);
			return;
		}
		// api/...
		if (count($uri_parts) >= 2 and $uri_parts[0]=='api') {
			if ($uri_parts[1] == 'tg') {
				$tg = new \Api\tg\ApiController();
				$tg->process(array_slice($uri_parts, 2));
				return;
			}
			$prefix = substr($uri_parts[1],0,1);
			$version = intval(substr($uri_parts[1], 1));
			$classname = 'Api\\v'.$version.'\\ApiController';
			if ($prefix == 'v' and $version > 0 and class_exists($classname)) {
				$api = new $classname();
				$api->process(array_slice($uri_parts, 2));
				return;
			} else {
				\Views\ViewHelper::renderError(404);
				return;
			}
		}
		\Views\ViewHelper::renderError(404);
	}
}
