<?php
$baseAddr = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/create_copy/";
define ("BASE_URL" , $baseAddr);
?>