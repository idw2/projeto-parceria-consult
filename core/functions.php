<?php

function get_head() {
  require_once 'head.php';
}

function get_footer() {
  require_once 'footer.php';
}

function get_scripts() {
  require_once 'scripts.php';
}

function set_active($page, $item) {
  $item = explode(',', $item);
  foreach($item as $k=>$v){
    if ($v == $page){
    return 'active';
    }
  }
}
