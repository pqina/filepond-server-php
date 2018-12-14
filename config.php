<?php

// Load the FilePond helper class
require_once('FilePond/RequestHandler.class.php');

// Load Doka image transform class
require_once('Doka/Doka.class.php');

// Set temp file location
FilePond\RequestHandler::$tmp_dir = 'tmp' . DIRECTORY_SEPARATOR;

// Create a Doka transform function
function applyDokaImageTransform($item, $source, $target) {
    
    $metadata = $item->getMetadata();

    // No metadata found, just copy the file
    if (!isset($metadata)) {
        return rename($source, $target);
    }

    // A list of transforms already applied on the client, we need these as we don't have to apply them again
    $clientTransforms = isset($metadata->transform) ? $metadata->transform->client : [];

    // Build the output object based on the transform property
    $output = [
        'quality' => isset($metadata->transform) ? $metadata->transform->quality : null,
        'type' => isset($metadata->transform) ? $metadata->transform->type : null
    ];

    // The metadata object contains the server transforms to apply
    $serverTransforms = $metadata;

    // Remove transforms already applied on the client
    foreach($clientTransforms as $clientTransform) {
        if (!property_exists($serverTransforms, $clientTransform)) {
            continue;
        }
        unset($serverTransforms->{$clientTransform});
    }

    // Transform and save the file
    Doka\transform(
        $source,
        $target,
        $serverTransforms,
        $output
    );
}

FilePond\RequestHandler::$file_store_function = 'applyDokaImageTransform';