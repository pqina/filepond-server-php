<?php

// Load the FilePond helper class
require_once('FilePond/RequestHandler.class.php');

require_once('Doka/Doka/Doka.class.php');

// Set temp file location
FilePond\RequestHandler::$tmp_dir = 'tmp' . DIRECTORY_SEPARATOR;

// Set transform function
function applyDokaTransform($item, $source, $target) {
    
    echo $source . '<br>';
    echo $target . '<br>';

    print_r($item->getMetadata());

    Doka\transform(
        $source,
        'doka_' . $target,
        $item->getMetadata()
    );
}

FilePond\RequestHandler::$file_store_function = 'applyDokaTransform';