<?php

class tmpStart {

	public $config;

	public function __construct() {

		// helpers
		require_once($_SERVER['DOCUMENT_ROOT'].'/core/function.php');

		// Файл конфигурации
		$this->config = require_once($_SERVER['DOCUMENT_ROOT'].'/core/config.php');

		// Текущий раздел
		$this->config['SECTION'] = @$this->config['ROUTE'][$_SERVER['REQUEST_URI']];
		if(empty($this->config['SECTION'])) die("Страница не существует");

		// Формируем и буфферизуем страницу
		ob_start();
		require_once($_SERVER['DOCUMENT_ROOT']."/core/templates/".$this->config['DESIGN']);
		$this->config['PAGE'] = ob_get_contents();
		ob_end_clean();

		// Вывод страницы
		echo $this->config['PAGE'];

		// Формирование статической страницы (в корне)
		if($this->config['STATIC']) {
			$firstSymbol = substr($_SERVER['REQUEST_URI'], 1);
			$filename = empty($firstSymbol) ? 'index' : str_replace("/", ".", $firstSymbol);
			file_put_contents($_SERVER['DOCUMENT_ROOT']."/".$filename.".html", $this->config['PAGE']);
		}

	}

	// Подключение файл-блоков в шаблон страницы
	public function content() {
		foreach($this->config['SECTION'] as $blockFile) {
			require_once($_SERVER['DOCUMENT_ROOT'].'/core/templates/block/'.$blockFile);
		}
	}

}

new tmpStart;
