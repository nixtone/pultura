<?
return [

	// Шаблон сайта
	'DESIGN' => "index.php",

	// Формирование статической страницы
	'STATIC' => 0,

	// Разделы
	'ROUTE' => [

		// Заказы
		'/' => [
			'order-list.php',	
		],
		'/order' => [
			'order.php',
		],
		'/order-new' => [
			'order-new.php',
		],
		
		// Клиенты
		'/client-list' => [
			'client-list.php',
		],
		'/client-item' => [
			'client-item.php',
		],
		'/client-new' => [
			'client-new.php',
		],

		// тиу
		'/product-list' => [
			'product-list.php',
		],
		'/product-new' => [
			'product-new.php',
		],

		// Сотрудники
		'/personal' => [
			'personal.php',
		],

	],
	
];
