<?php
error_reporting(E_ALL ^ E_WARNING);

require __DIR__.'/../src/util.php';

sendPdf($_GET['url']);
