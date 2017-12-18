<?php
error_reporting(E_ALL ^ E_WARNING);

require __DIR__.'/../vendor/autoload.php';


Betafcc\SaveAsPdf::sendPdf($_GET['url']);
