<?php

function get_head() {
  require_once ROOT . '/partials/head.php';
}

function get_footer() {
  require_once ROOT .  '/partials/footer.php';
}

function get_scripts() {
  require_once  ROOT . '/partials/scripts.php';
}

function set_active($page, $item) {
  $item = explode(',', $item);
  foreach($item as $k=>$v){
    if ($v == $page){
    return 'active';
    }
  }
}

function uploads($file){
    return SITE . DS . 'uploads' . DS  . $file;
}

function rearrange_files($arr) {
    foreach($arr as $key => $all) {
        foreach($all as $i => $val) {
            $new_array[$i][$key] = $val;    
        }    
    }
    return $new_array;
}

function slug($string, $separator = '-') {
	$accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
	$special_cases = array(
		'&' => 'and'
	);
	$string = mb_strtolower(trim($string) , 'UTF-8');
	$string = str_replace(array_keys($special_cases) , array_values($special_cases) , $string);
	$string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
	$string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
	$string = preg_replace("/[$separator]+/u", "$separator", $string);
	$string = trim($string, '-');
	return $string;
}

function specials($string) {
	$accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
	$special_cases = array(
		'&' => 'e'
	);
	$string = trim($string);
	$string = str_replace(array_keys($special_cases) , array_values($special_cases) , $string);
	$string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES));
	return $string;
}

function body_class(){
    echo 'page-' . str_replace('/', '_', $_GET['url']);
}