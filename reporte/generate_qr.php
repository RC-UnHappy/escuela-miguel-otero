<?php

include '../libs/phpqrcode/phpqrcode.php';

$text = $_GET['codigo_qr'];
QRcode::png($text);
