<?

function p($data, $flag = 'pr') {
	echo "<pre style=\"background:#ececec; color:black; font-size:1em; margin:10px 0; padding: 10px; white-space:pre-wrap; \">";
	switch ($flag) {
		case 'pr': print_r($data); break;
		case 'vd': var_dump($data); break;
	}
	echo "</pre>";
}