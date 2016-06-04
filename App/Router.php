<?php

namespace App;

class Router {
	public static function process() {
		$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		//index
		if ($url_path == '/') {
			$groupSchedule = Router::getSchdule(15);
			echo json_encode($groupSchedule, JSON_UNESCAPED_UNICODE);
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
	private static function getSchdule($group_id) {
    	$a = array ( 0 => array ( 'week_id' => $group_id, 'week' => 'Нечетная', 'days' => array ( 0 => array ( 'day_id' => 1, 'day' => 'Понедельник', 'events' => array ( 0 => array ( 'event_index' => 2, 'course_id' => 994, 'course' => 'Сети и телекоммуникации', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 862, 'teacher' => 'Торчинский В.Е.', 'location' => '1-441', ), 1 => array ( 'event_index' => 3, 'course_id' => 997, 'course' => 'Методы управления знаниями', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 566, 'teacher' => 'Миков А.Ю.', 'location' => '2-282М', ), 2 => array ( 'event_index' => 4, 'course_id' => 995, 'course' => 'ЭВМ и периферийные устройства', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 1006, 'teacher' => 'Ячиков И.М.', 'location' => '2-282М', ), ), ), 1 => array ( 'day_id' => 2, 'day' => 'Вторник', 'events' => array ( ), ), 2 => array ( 'day_id' => 3, 'day' => 'Среда', 'events' => array ( 0 => array ( 'event_index' => 2, 'course_id' => 336, 'course' => 'Философия', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 64, 'teacher' => 'Ахметзянова М.П.', 'location' => '1-365', ), 1 => array ( 'event_index' => 3, 'course_id' => 994, 'course' => 'Сети и телекоммуникации', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 361, 'teacher' => 'Калитаев А.Н.', 'location' => '2-372/1к', ), 2 => array ( 'event_index' => 4, 'course_id' => 567, 'course' => 'Базы данных', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 95, 'teacher' => 'Белявский А.Б.', 'location' => '2-372/4к', ), ), ), 3 => array ( 'day_id' => 4, 'day' => 'Четверг', 'events' => array ( 0 => array ( 'event_index' => 1, 'course_id' => 567, 'course' => 'Базы данных', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 95, 'teacher' => 'Белявский А.Б.', 'location' => '2-282М', ), 1 => array ( 'event_index' => 2, 'course_id' => 995, 'course' => 'ЭВМ и периферийные устройства', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 1006, 'teacher' => 'Ячиков И.М.', 'location' => '1-337к', ), 2 => array ( 'event_index' => 2, 'course_id' => 995, 'course' => 'ЭВМ и периферийные устройства', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 188, 'teacher' => 'Гладышева М.М.', 'location' => '1-144/1к', ), 3 => array ( 'event_index' => 3, 'course_id' => 479, 'course' => 'Физическая культура', 'type_id' => 1, 'type' => 'пр. зан.', 'subgroup' => 0, 'teacher_id' => 115, 'teacher' => 'Бородина Ю.С.', 'location' => '1-с/зал', ), ), ), 4 => array ( 'day_id' => 5, 'day' => 'Пятница', 'events' => array ( 0 => array ( 'event_index' => 1, 'course_id' => 999, 'course' => 'Операционные системы', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 334, 'teacher' => 'Ильина Е.А.', 'location' => '2-282М', ), 1 => array ( 'event_index' => 2, 'course_id' => 999, 'course' => 'Операционные системы', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 334, 'teacher' => 'Ильина Е.А.', 'location' => '2-372/1к', ), 2 => array ( 'event_index' => 2, 'course_id' => 998, 'course' => 'Компьютерное моделирование технологических процессов', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 491, 'teacher' => 'Кухта Ю.Б.', 'location' => '1-245к', ), 3 => array ( 'event_index' => 3, 'course_id' => 998, 'course' => 'Компьютерное моделирование технологических процессов', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 491, 'teacher' => 'Кухта Ю.Б.', 'location' => '1-245к', ), 4 => array ( 'event_index' => 3, 'course_id' => 999, 'course' => 'Операционные системы', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 334, 'teacher' => 'Ильина Е.А.', 'location' => '2-372/1к', ), 5 => array ( 'event_index' => 4, 'course_id' => 998, 'course' => 'Компьютерное моделирование технологических процессов', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 491, 'teacher' => 'Кухта Ю.Б.', 'location' => '2-282М', ), 6 => array ( 'event_index' => 5, 'course_id' => 994, 'course' => 'Сети и телекоммуникации', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 552, 'teacher' => 'Мацко И.И.', 'location' => '2-372/1к', ), ), ), 5 => array ( 'day_id' => 6, 'day' => 'Суббота', 'events' => array ( 0 => array ( 'event_index' => 3, 'course_id' => 315, 'course' => 'Экономика', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 263, 'teacher' => 'Егорова Л.Г.', 'location' => '1-247к', ), 1 => array ( 'event_index' => 3, 'course_id' => 997, 'course' => 'Методы управления знаниями', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 566, 'teacher' => 'Миков А.Ю.', 'location' => '1-245к', ), 2 => array ( 'event_index' => 4, 'course_id' => 997, 'course' => 'Методы управления знаниями', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 566, 'teacher' => 'Миков А.Ю.', 'location' => '1-245к', ), 3 => array ( 'event_index' => 4, 'course_id' => 315, 'course' => 'Экономика', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 263, 'teacher' => 'Егорова Л.Г.', 'location' => '1-247к', ), 4 => array ( 'event_index' => 5, 'course_id' => 315, 'course' => 'Экономика', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 263, 'teacher' => 'Егорова Л.Г.', 'location' => '2-282М', ), 5 => array ( 'event_index' => 6, 'course_id' => 567, 'course' => 'Базы данных', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 263, 'teacher' => 'Егорова Л.Г.', 'location' => '2-372/4к', ), ), ), 6 => array ( 'day_id' => 7, 'day' => 'Воскресенье', 'events' => array ( ), ), ), ), 1 => array ( 'week_id' => 2, 'week' => 'Четная', 'days' => array ( 0 => array ( 'day_id' => 1, 'day' => 'Понедельник', 'events' => array ( ), ), 1 => array ( 'day_id' => 2, 'day' => 'Вторник', 'events' => array ( 0 => array ( 'event_index' => 2, 'course_id' => 994, 'course' => 'Сети и телекоммуникации', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 361, 'teacher' => 'Калитаев А.Н.', 'location' => '2-372/1к', ), 1 => array ( 'event_index' => 3, 'course_id' => 479, 'course' => 'Физическая культура', 'type_id' => 1, 'type' => 'пр. зан.', 'subgroup' => 0, 'teacher_id' => 115, 'teacher' => 'Бородина Ю.С.', 'location' => '1-с/зал', ), 2 => array ( 'event_index' => 4, 'course_id' => 995, 'course' => 'ЭВМ и периферийные устройства', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 1006, 'teacher' => 'Ячиков И.М.', 'location' => '2-282М', ), 3 => array ( 'event_index' => 5, 'course_id' => 995, 'course' => 'ЭВМ и периферийные устройства', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 1006, 'teacher' => 'Ячиков И.М.', 'location' => '2-372/2к', ), 4 => array ( 'event_index' => 5, 'course_id' => 995, 'course' => 'ЭВМ и периферийные устройства', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 188, 'teacher' => 'Гладышева М.М.', 'location' => '1-144/1к', ), ), ), 2 => array ( 'day_id' => 3, 'day' => 'Среда', 'events' => array ( 0 => array ( 'event_index' => 1, 'course_id' => 567, 'course' => 'Базы данных', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 95, 'teacher' => 'Белявский А.Б.', 'location' => '2-372/4к', ), 1 => array ( 'event_index' => 2, 'course_id' => 567, 'course' => 'Базы данных', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 95, 'teacher' => 'Белявский А.Б.', 'location' => '2-376', ), 2 => array ( 'event_index' => 3, 'course_id' => 336, 'course' => 'Философия', 'type_id' => 1, 'type' => 'пр. зан.', 'subgroup' => 0, 'teacher_id' => 64, 'teacher' => 'Ахметзянова М.П.', 'location' => '1-157', ), ), ), 3 => array ( 'day_id' => 4, 'day' => 'Четверг', 'events' => array ( 0 => array ( 'event_index' => 1, 'course_id' => 999, 'course' => 'Операционные системы', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 334, 'teacher' => 'Ильина Е.А.', 'location' => '2-282М', ), 1 => array ( 'event_index' => 2, 'course_id' => 994, 'course' => 'Сети и телекоммуникации', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 862, 'teacher' => 'Торчинский В.Е.', 'location' => '2-282М', ), 2 => array ( 'event_index' => 3, 'course_id' => 160, 'course' => 'Экология', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 161, 'teacher' => 'Волкова Е.А.', 'location' => '1-431', ), 3 => array ( 'event_index' => 4, 'course_id' => 160, 'course' => 'Экология', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 161, 'teacher' => 'Волкова Е.А.', 'location' => '1-335', ), 4 => array ( 'event_index' => 4, 'course_id' => 160, 'course' => 'Экология', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 62, 'teacher' => 'Афонина Е.А.', 'location' => '1-335', ), ), ), 4 => array ( 'day_id' => 5, 'day' => 'Пятница', 'events' => array ( 0 => array ( 'event_index' => 3, 'course_id' => 998, 'course' => 'Компьютерное моделирование технологических процессов', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 491, 'teacher' => 'Кухта Ю.Б.', 'location' => '1-245к', ), 1 => array ( 'event_index' => 3, 'course_id' => 999, 'course' => 'Операционные системы', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 334, 'teacher' => 'Ильина Е.А.', 'location' => '2-372/1к', ), 2 => array ( 'event_index' => 4, 'course_id' => 999, 'course' => 'Операционные системы', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 334, 'teacher' => 'Ильина Е.А.', 'location' => '2-372/1к', ), 3 => array ( 'event_index' => 4, 'course_id' => 998, 'course' => 'Компьютерное моделирование технологических процессов', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 491, 'teacher' => 'Кухта Ю.Б.', 'location' => '1-245к', ), 4 => array ( 'event_index' => 5, 'course_id' => 998, 'course' => 'Компьютерное моделирование технологических процессов', 'type_id' => 2, 'type' => 'лекция', 'subgroup' => 0, 'teacher_id' => 491, 'teacher' => 'Кухта Ю.Б.', 'location' => '2-282М', ), 5 => array ( 'event_index' => 6, 'course_id' => 994, 'course' => 'Сети и телекоммуникации', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 552, 'teacher' => 'Мацко И.И.', 'location' => '2-372/1к', ), ), ), 5 => array ( 'day_id' => 6, 'day' => 'Суббота', 'events' => array ( 0 => array ( 'event_index' => 2, 'course_id' => 479, 'course' => 'Физическая культура', 'type_id' => 1, 'type' => 'пр. зан.', 'subgroup' => 0, 'teacher_id' => 115, 'teacher' => 'Бородина Ю.С.', 'location' => '1-с/зал', ), 1 => array ( 'event_index' => 3, 'course_id' => 315, 'course' => 'Экономика', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 263, 'teacher' => 'Егорова Л.Г.', 'location' => '1-247к', ), 2 => array ( 'event_index' => 3, 'course_id' => 997, 'course' => 'Методы управления знаниями', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 566, 'teacher' => 'Миков А.Ю.', 'location' => '1-245к', ), 3 => array ( 'event_index' => 4, 'course_id' => 997, 'course' => 'Методы управления знаниями', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 566, 'teacher' => 'Миков А.Ю.', 'location' => '1-245к', ), 4 => array ( 'event_index' => 4, 'course_id' => 315, 'course' => 'Экономика', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 2, 'teacher_id' => 263, 'teacher' => 'Егорова Л.Г.', 'location' => '1-247к', ), 5 => array ( 'event_index' => 5, 'course_id' => 567, 'course' => 'Базы данных', 'type_id' => 3, 'type' => 'Лабораторные', 'subgroup' => 1, 'teacher_id' => 263, 'teacher' => 'Егорова Л.Г.', 'location' => '2-372/4к', ), ), ), 6 => array ( 'day_id' => 7, 'day' => 'Воскресенье', 'events' => array ( ), ), ), ), );
		for ($week_id=0; $week_id < count($a); $week_id++) { 
			$week = $a[$week_id];
			for ($day_id=0; $day_id < count($week['days']); $day_id++) { 
				$b = $a[$week_id]['days'][$day_id]['events'];
				$a[$week_id]['days'][$day_id]['events'] = [];
				
				for ($i=1; $i <= 8; $i++) { 
					$a[$week_id]['days'][$day_id]['events'][$i] = [];
					foreach ($b as $event) {
						if ($event['event_index'] == $i) {
							$a[$week_id]['days'][$day_id]['events'][$i][] = $event;
						}
					}
				}
			}
		}
		return $a;
    }
}