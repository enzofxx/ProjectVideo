<?php

if (!function_exists('dd')) {

    function dd($var)
    {
        echo '<pre style="padding: 10px 0px 10px 25px; background-color: black; color: white;">';
        var_dump($var);
        echo '</pre>';
        exit(0);
    }
}
if (!function_exists('dc')) {

    function dc($var)
    {
        echo '<pre style="padding: 10px 0px 10px 25px; background-color: black; color: white;">';
        var_dump($var);
        echo '</pre>';
    }
}


function redirect(string $to = null)
{
    return new \App\Core\Support\Helpers\Redirect($to);
}

function view(string $name, array $data = [])
{
    return new \App\Core\Support\Helpers\View($name, $data);
}

function checkForUploadErrors($image)
{
    $errors = [];

//    Check if file exists
    if (empty($image)) {
        $errors[] = 'File is missing';
    }
//    Check the upload time errors
    if ($image->getError() !== 0) {
        if ($image['error'] === 1) {
            $errors[] = 'Max upload size exceeded';
        } else {
            $errors[] = 'Image uploading error: INI Error';
        }
    }

//    Validate the file size
    $maxFileSize = 10 * 10e6; // = 10 000 000 bytes = 10MB
    if ($image->getSize() > $maxFileSize) {
        $errors[] = 'Max size (10MB) limit exceeded';
    }

//    Validate the image mime type (Do this according to your needs)
    $mimeType = $image->getClientMimeType();
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mimeType, $allowedMimeTypes)) {
        $errors[] = 'Only JPEG, PNG and GIFs are allowed';
    }

    if (isset($errors)) {
        echo "Response from SERVER";
        echo "<br>";
        echo "You hacked front-end but not the server";
        echo "<br>";
        foreach ($errors as $er) {
            echo $er . "<br>";
        }
        die();
    }
}