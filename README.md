# FilePond PHP Server API

A PHP server to handle [FilePond](https:pqina.nl/filepond) file uploads and [Doka](https://pqina.nl/doka) image transforms.


## Instructions

Comment this line in both the `index.php` and `submit.php` files to prevent posting to the server from other domains.

```php
header('Access-Control-Allow-Origin: *');
```


## Targets

The `tmp` and `upload` file paths can be configured in the `config.php` file.

```php

// where to get files from, can also be an array of fields
const ENTRY_FIELD = 'filepond'; 

// where to write files to
const TRANSFER_DIR = 'tmp';
const UPLOAD_DIR = 'uploads';
const VARIANTS_DIR = 'variants';

// name to use for the file metadata object
const METADATA_FILENAME = '.metadata';

```


## Image Transforms

To do image transforms on the server instead of the client we can uncomment the `require_once('config_doka.php')` line.

Transform instructions found in the `.metadata` file are now automatically applied to the first file in the upload list (when it's transfered from the transfer dir to the upload dir).


## Example

See [FilePond PHP Boiler Plate](https://github.com/pqina/filepond-boilerplate-php) for an example implementation.