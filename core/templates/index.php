<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/ico" href="/favicon.ico">
<title>CRM памятники</title>
<link rel="stylesheet" href="static/custom.css">
</head>
<body>
<div id="wrapper">

<header>
	<div class="container">
		<a href="/" id="logo"><img src="/static/images/logo.png" alt="" class="bimg" style="width: 36px;"></a>
		<nav>
			<a href="/" class="active">Заказы</a>
			<a href="/client-list">Клиенты</a>
			<a href="/product-list">Услуги и наименования</a>
			<a href="/personal">Сотрудники</a>
		</nav>
	</div>
</header>

<? $this->content() ?>

</div>
<footer>
	<div class="container">&copy; CRM памятники <?=date('Y')?></div>
</footer>

<div class="overlay" style="display: none;">
	<div class="popup">
	    <div class="close"></div>
	    <div class="inner">

	        <form method="post" class="callback" style="display: none;">
	            <input type="text" name="NAME" placeholder="Ваше имя">
	            <input type="text" name="PHONE" placeholder="Телефон">
	            <input type="text" name="EMAIL" placeholder="E-mail">
	            <input type="submit" value="Отправить">
	        </form>

	        <div class="cross" style="display: none;">
	        	<img src="/static/images/upload/1.png" alt="" class="bimg preview" data-value="1">
	        	<img src="/static/images/upload/2.png" alt="" class="bimg preview" data-value="2">
	        	<img src="/static/images/upload/3.png" alt="" class="bimg preview" data-value="3">
	        	<img src="/static/images/upload/4.png" alt="" class="bimg preview" data-value="4">
	        	<img src="/static/images/upload/5.png" alt="" class="bimg preview" data-value="5">
	        	<img src="/static/images/upload/6.png" alt="" class="bimg preview" data-value="6">
	        </div>

	    </div>
	</div>
</div>

<script src="/static/jquery-3.6.0.min.js"></script>
<script src="/static/jquery.maskedinput.min.js"></script>
<script src="/static/custom.js"></script>
</body>
</html>