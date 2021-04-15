<?php
$baseAddr = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/auto_copy_service/";
define ("BASE_URL" , $baseAddr);
?>