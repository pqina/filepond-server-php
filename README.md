# FilePond PHP Server API

A PHP server to handle [FilePond](https:pqina.nl/filepond) file uploads.

The `tmp` file path can be configured in the `config.php` file.

```php
FilePond\RequestHandler::$tmp_dir = 'tmp' . DIRECTORY_SEPARATOR;
```

Comment this line in both the `index.php` and `submit.php` files to prevent posting to the server from other domains.

```php
header('Access-Control-Allow-Origin: *');
```

See [FilePond PHP Boiler Plate](https://github.com/pqina/filepond-boilerplate-php) for an example implementation.