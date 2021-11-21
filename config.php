<?php

// where to get files from
const ENTRY_FIELD = array('filepond');

// where to write files to
const TRANSFER_DIR = __DIR__ . '/tmp';
const UPLOAD_DIR = __DIR__ . '/uploads';
const VARIANTS_DIR = __DIR__ . '/variants';

// name to use for the file metadata object
const METADATA_FILENAME = '.metadata';

// allowed file formats, if empty all files allowed
const ALLOWED_FILE_FORMATS = array(
    // images
    'image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/tiff', 'image/webp',

    // video
    'video/mpeg', 'video/mp4', 'video/x-msvideo', 'video/webm', 'video/ogg',

    // audio
    'audio/mpeg', 'audio/ogg', 'audio/mpeg', 'audio/webm',

    // docs
    'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.oasis.opendocument.spreadsheet','application/vnd.oasis.opendocument.text',
    'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
);

// this automatically creates the upload and transfer directories, if they're not there already
if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755);
if (!is_dir(TRANSFER_DIR)) mkdir(TRANSFER_DIR, 0755);

// this is optional and only needed if you're doing server side image transforms, if images are transformed on the clients, this can stay commented
// require_once('config_doka.php');
