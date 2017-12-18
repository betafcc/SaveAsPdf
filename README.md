# SaveAsPdf

A helper to download any url as PDF with php, using phantomJS


## What

```php
Betafcc\SaveAsPdf::sendPdf(string $url, string $filename=null)
```

Get the $url and send to download with name as $filename or a random name


## Example

```php
<?php
// index.php
require 'vendor/autoload.php';

Betafcc\SaveAsPdf::sendPdf($_GET['url'], 'foo.pdf');
```

Then acess `http://<host>/index.php?url=<url_to_save_as_pdf>` and a `foo.pdf` download will start
