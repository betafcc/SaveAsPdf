<?php declare(strict_types=1);

error_reporting(E_ALL ^ E_WARNING);

require __DIR__.'/../vendor/autoload.php';

use JonnyW\PhantomJs\Client;


function sendPdf(string $url, string $filename=null) {
    $tempfile = tempnam(sys_get_temp_dir(), 'client-pdf-') . '.pdf';

    saveAsPdf($url, $tempfile);
    sendFile($tempfile, $filename);

    unlink($tempfile);
}


function saveAsPdf(string $url, string $outputFile, string $enginePath=null) {
    $client = Client::getInstance();

    if ($enginePath === null)
        $client
            ->getEngine()
            ->setPath(__DIR__.'/../bin/phantomjs');

    $request = $client
        ->getMessageFactory()
        ->createPdfRequest($url, 'GET');

    $response = $client
        ->getMessageFactory()
        ->createResponse();

    $request->setOutputFile($outputFile);
    $request->setFormat('A4');
    $request->setOrientation('landscape');
    $request->setMargin('1cm');

    $client
        ->send($request, $response);

    $responseStatus = $response->getStatus();
    if ($responseStatus >= 400)
        throw new Exception("Response returned with code $responseStatus");
}


function sendFile(string $origin, string $filename=null, int $filesize=null) {
    if ($filename === null)
        $filename = basename($origin);
    if ($filesize === null)
        $filesize = filesize($origin);

    $headers = [
        'Content-Description: File Transfer',
        'Content-Type: application/octet-stream',
        'Content-Disposition: attachment; filename="'.$filename.'"',
        'Expires: 0',
        'Cache-Control: must-revalidate',
        'Pragma: public',
        'Content-Length: ' . $filesize
    ];

    foreach ($headers as $header)
        header($header);

    readfile($origin);
}


