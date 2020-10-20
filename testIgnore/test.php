<?php

require_once '../vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

$app = new \Slim\App($configuration);

$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/uploads';

$app->post('/', function(Request $request, Response $response, array $args) {
    $directory = $this->get('upload_directory');

    //echo $directory;
    
    $uploadedFiles = $request->getUploadedFiles();
    /*
    // handle single input with single file upload
    $uploadedFile = $uploadedFiles['example1'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $filename = moveUploadedFile($directory, $uploadedFile);
        $response->write('uploaded ' . $filename . '<br/>');
    }

    // handle multiple inputs with the same key
    foreach ($uploadedFiles['example2'] as $uploadedFile) {
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
            $response->write('uploaded ' . $filename . '<br/>');
        }
    }
    */

    // handle single input with multiple file uploads
    
    foreach ($uploadedFiles['example3'] as $uploadedFile) {
        //$uploadedFile = $uploadedFiles['example3'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
            $response->write('uploaded ' . $filename . '<br/>');
        }
    }
});

function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}

$app->run();


