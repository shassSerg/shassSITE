<?php
ini_set('display_errors', 'Off');
ob_start();
http_response_code(200);
header('Connection: close');
header('Content-Length: '.ob_get_length());
ob_end_flush();
ob_flush();
flush();




exit;
?>
