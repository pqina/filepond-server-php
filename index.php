<?php

// Comment if you don't want to allow posts from other domains
header('Access-Control-Allow-Origin: *');

// Allow the following methods to access this file
header('Access-Control-Allow-Methods: OPTIONS, GET, DELETE, POST');

// Load the FilePond class
require_once('FilePond.class.php');

// Load our configuration for this server
require_once('config.php');

// catch server exceptions and auto jump to 500 response code if caught
FilePond\catch_server_exceptions();

// Route request to handler method
FilePond\route_api_request(ENTRY_FIELD, [
    'FILE_TRANSFER' => 'handle_file_transfer',
    'REVERT_FILE_TRANSFER' => 'handle_revert_file_transfer',
    'RESTORE_FILE_TRANSFER' => 'handle_restore_file_transfer',
    'LOAD_LOCAL_FILE' => 'handle_load_local_file',
    'FETCH_REMOTE_FILE' => 'handle_fetch_remote_file'
]);

function handle_file_transfer($transfer) {

    $metadata = $transfer->getMetadata();
    $files = $transfer->getFiles();

    // something went wrong, most likely a field name mismatch
    if (count($files) === 0) { return http_response_code(400); }

    // store files
    FilePond\store_transfer(TRANSFER_DIR, $transfer);
    
    // returns plain text content
    header('Content-Type: text/plain');

    // remove item from array Response contains uploaded file server id
    echo $transfer->getId();
}

function handle_revert_file_transfer($id) {

    // test if id was supplied
    if (!isset($id) || !FilePond\is_valid_transfer_id($id)) { return http_response_code(400); }

    // remove transfer directory
    FilePond\remove_transfer_directory(TRANSFER_DIR, $id);

    // no content to return
    http_response_code(204);
}

function handle_restore_file_transfer($id) {

    // Stop here if no id supplied
    if (empty($id) || !FilePond\is_valid_transfer_id($id)) return http_response_code(400);

    // create transfer wrapper around upload
    $transfer = FilePond\get_transfer(TRANSFER_DIR, $id);

    // Let's get the temp file content
    $files = $transfer->getFiles();

    // No file returned, file not found
    if (count($files) === 0) return http_response_code(404);

    // return first file
    $file = FilePond\read_file($files[0]['tmp_name']);

    // something went wrong while reading the file
    if (!$file) return http_response_code(500);

    // Return file
    FilePond\echo_file($file);
}

function handle_load_local_file($ref) {

    // Stop here if no id supplied
    if (empty($ref)) { return http_response_code(400); }

    // In this example implementation the file id is simply the filename and 
    // we request the file from the uploads folder, it could very well be 
    // that the file should be fetched from a database or a totally different system.
    
    // path to file
    $path = UPLOAD_DIR . DIRECTORY_SEPARATOR . FilePond\sanitize_filename($ref);

    // return first file
    $file = FilePond\read_file($path);
    
    // something went wrong while reading the file
    if (!$file) return http_response_code(500);

    // Return file
    FilePond\echo_file($file);
}

function handle_fetch_remote_file($url) {

    // Stop here if no data supplied
    if (empty($url)) return http_response_code(400);

    // Is this a valid url
    if (!FilePond\is_url($url)) return http_response_code(400);

    // Let's try to get the remote file content
    $response = FilePond\fetch($url);

    // Something went wrong
    if ($response === null) return http_response_code(500);

    // remote server returned invalid response
    if (!$response['success']) return http_response_code($response['code']);
    
    // Return file
    header('Content-Type: ' . $response['type']);
    header('Content-Length: ' . $response['length']);
    echo $response['content'];
}