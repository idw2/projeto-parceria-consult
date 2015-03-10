<?php
define('DS', DIRECTORY_SEPARATOR);
//define('PATH', (__DIR__) . DS);
define('PATH', '');

if ($_SERVER['REMOTE_ADDR'] != '177.142.180.77')
    die;

//echo PATH;
//die;

require 'core/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $upload_path = PATH . 'uploads' . DS . date("Y") . DS . date("m") . DS;

    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    $files = rearrange_files($_FILES['files']);
    echo '<pre>';
//    print_r($files);
    echo '</pre>';

    foreach ($files as $k => $file) {
        if (!is_file($file['name'])) {
            move_uploaded_file($file['tmp_name'], $file['name']);
            echo 'hey';
        } else {
            move_uploaded_file($upload_path . crc32(time()) . '_' . $file['name'], $file['tmp_name']);
        }
    }
}
?>
<html>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
            <input name="files[]" type="file" multiple>
            <button type="submit">enviar</button>
        </form>
    </body>
</html>