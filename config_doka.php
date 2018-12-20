<?php

// Load Doka image transform class, used to do the image transforms on the server
require_once('Doka/Doka.class.php');

// Load FilePond class, we'll use this to create a new file object later on
require_once('FilePond.class.php');

// should we apply image transforms to the files
const TRANSFER_PROCESSOR = 'filepond_transfer_processor';
const TRANSFER_PROCESSOR_FILE_PREFIX = 'processed_';

// doka mutator function
function filepond_transfer_processor($files, $metadata) {
    
    // no instructions for server modification available
    if (!isset($metadata)) return $files;

    // parse metadata
    $metadata = FilePond\read_file_contents($metadata['tmp_name']);
    if (!$metadata) return $files;

    // continue with parsed metadata
    $metadata = @json_decode($metadata);

    // we only apply transforms to the first file, as that is either the original file, it would be weird to re-transform any variants
    $source = $files[0]['tmp_name'];

    // we'll create a copy of this file and then overwrite the array index with that copy
    $info = pathinfo($source);
    
    // Build target directory
    $target = $info['dirname'] . DIRECTORY_SEPARATOR . TRANSFER_PROCESSOR_FILE_PREFIX . $info['basename'];

    // Define transforms (it's basically the metadata object)
    $transforms = $metadata;

    // Build the output object based on the transform property
    $output = isset($metadata->transform) ? [
        'quality' => $metadata->transform->quality,
        'type' => $metadata->transform->type
    ] : [];

    // Transform and save the file
    $result = Doka\transform(
        $source,
        $target,
        $transforms,
        $output
    );

    // we'll put it back where it came from
    if ($result) {
        array_push($files, FilePond\create_file_object($target));
    }
    
    return $files;
}