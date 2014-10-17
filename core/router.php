<?php

class Router {

  private $url;
  private $view;
  private $default_title;

  public function __construct() {
    
  }

  public function load() {
    $get = $_GET;

    if (isset($get['url'])) {
      $params = explode('/', $get['url']);
//      unset($get['url']);


      $this->url = $params[0];
      if (isset($params[1]))
        $this->view = $params[1];
    }

    if ($this->url == '')
      $this->url = 'home';


    $default_title = 'People Oriented';

    /*
      if ($this->url != 'home') {
      if ($this->view != "") {
      $page_title = ucfirst($this->view) . ' - ' . $page_title;
      } else {
      $page_title = ucfirst($this->url) . ' - ';
      }
      }
     */

    $this->url = str_replace('-', '_', $this->url);

    if ($this->view == "") {
      $pagina = PAGINAS . DS . $this->url . '.php';
    } else {
      $pagina = PAGINAS . DS . $this->url . DS . $this->view . '.php';
    }

    if (is_file($pagina)) {
      require $pagina;
    } else {
      echo '<script>window.location.href="' . SITE . DS . '404.php"</script>';
    }
  }

  public function get_view() {
    return $this->view;
  }

  public function get_title() {
    switch ($this->url) {
      case 'home':
        return 'Home';
        break;

      default:
        return 'Home';
        break;
    }
  }

}
